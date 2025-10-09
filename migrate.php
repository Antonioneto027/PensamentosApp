<?php

 

        $host = '127.0.0.1';
        $db   = 'teste_thoughts_db';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die('Erro ao conectar: ' . $e->getMessage());
        }

 
$stmt = $pdo->query("SELECT version FROM schema_migrations");
 
$appliedVersions = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo "Versões já aplicadas no banco de dados: " . (count($appliedVersions) > 0 ? implode(', ', $appliedVersions) : "Nenhuma") . "\n";

$migrationFiles = glob('db/migrations/*.sql');
 
sort($migrationFiles);

echo "Procurando por novas migrações...\n";

foreach ($migrationFiles as $file) {
  
    $fileName = basename($file);
    
    if (!in_array($fileName, $appliedVersions)) {
        
        
        
        try {
         //   $pdo->beginTransaction();
            $sql = file_get_contents($file);
            $pdo->exec($sql);
            $stmt = $pdo->prepare("INSERT INTO schema_migrations (version) VALUES (?)");
            $stmt->execute([$fileName]);

         //   $pdo->commit();
            echo " -> Migração aplicada com sucesso: " . $fileName . "\n";

        } catch (Exception $e) {
        //    $pdo->rollBack();
            echo "ERRO ao aplicar a migração " . $fileName . ": " . $e->getMessage() . "\n";
            exit;
        }
    }
}

echo "Versionamento do banco de dados concluído.\n";