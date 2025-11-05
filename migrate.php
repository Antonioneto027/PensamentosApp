<?php 
use Composer\Command\ExecCommand;


use App\Controllers\ConnectDb;
require 'vendor/autoload.php';

$db_name = 'globals';

$conn = chooseDb($db_name);

$stmt = $conn->query("SELECT version FROM schema_migrations"); ;

$appliedVersions = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo "Versões já aplicadas no banco de dados: " . (count($appliedVersions) > 0 ? implode(', ', $appliedVersions) : "Nenhuma") . "\n";


$migrationFilesGeneral = glob('db/migrations/general/*.sql'); 
sort($migrationFilesGeneral);

foreach ($migrationFilesGeneral as $generalFile) {
  
    $generalFileName = basename($generalFile);

    if (!in_array($generalFileName, $appliedVersions)) {
        try {
            $sql = file_get_contents($generalFile);
            $conn->exec($sql);
            $stmt = $conn->prepare("INSERT INTO schema_migrations (version) VALUES (?)");
            $stmt->execute([$generalFileName]);

        } catch (Exception $e) {
            echo "ERRO ao aplicar a migração " . $generalFileName . ": " . $e->getMessage() . "\n";
            exit;
        }
    }
}

echo "Versionamento do banco de dados {$db_name} concluído.\n";
echo "Iniciando versionamento dos bancos de dados de usuários...\n";

$migrationFilesUsers = glob('db/migrations/users/*.sql'); 
sort($migrationFilesUsers);


foreach ($migrationFilesUsers as $userFile) {
    
    $userFileName = basename($userFile);
    $sql = file_get_contents($userFile); 

    if (!in_array($userFileName, $appliedVersions)) {
         
        $dbToSwitch = glob('db/database/*.sqlite');
        sort($dbToSwitch);

            try { 
                
                foreach ($dbToSwitch as $db) {
                
                    $dbName = basename($db, ".sqlite");
                    if ($dbName != 'globals') {

                        $conn = chooseDb($dbName);
                        $conn->exec($sql);
                        $dbName = 'globals';
                        $db = chooseDb($dbName);
                        $stmt = $db->prepare("INSERT INTO schema_migrations (version) VALUES (?)");
                        $stmt->execute([$userFileName]);
                    }
                   
                }
         } catch (Exception $e) {
                echo "ERRO ao aplicar a migração " . $userFileName . ": " . $e->getMessage() . "\n";

         }
        
    }
  }

echo "Concluído o versionamento dos bancos de usuários.\n";





function chooseDb($db_name) {
     
     
        if ($db_name == 'globals') {
            session_start();
            $_SESSION['db'] = 'globals';
            require('config.php');
            $db = new ConnectDb();
            return $conn = $db->getConnection();
            
        } else {
            session_start();
            $_SESSION['db'] = $db_name;
            require('config.php');
            $db = new ConnectDb();
          return  $conn = $db->getConnection();
        }
        
         
}