<?php
namespace App\Todolist\Services;

use PDO;
use PDOException;

/**
 * gère la communication avec la BDD
 */
class Database{
    // propriétés de notre class

    /**
     * @var string
     */
    private string $db_host;

    /**
     * @var string
     */
    private string $db_name;

    /**
     * @var string
     */
    private string $db_port;

    /**
     * @var string
     */
    private string $db_user;

    /**
     * @var string
     */
    private string $db_pass;

    // propriété DSN 

    /**
     * @var string
     */
    private string $db_dsn;

    // PDO qu'on connait bien maintenant 

    /**
     * @var PDO
     */
    private string $pdo;  
    public  function __construct(
        $db_host,
        $db_name,
        $db_port,
        $db_user,
        $db_pass
    ){
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_port = $db_port;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_dsn = 'mysql:host='.$this->db_host.';port='.$this->db_port.';dbname='.$this->db_name.';charset=utf8';
    }

    /**
     * instancie PDO
     *
     * @return PDO
     */
    private  function getPDO(): PDO
    {
        // Si PDO n'est pas déjà connecté
        if ($this->pdo === null) {
        try {
            $db = new PDO($this->db_dsn,$this->db_user,$this->db_pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
             // tenter de réessayer la connexion après un certain délai, par exemple
                echo "Hum problème de connexion au serveur de base de données:  " .
                iconv('ISO-8859-1','UTF-8',$error->getMessage());
                die();
            }
            $this->pdo = $db;
        }
        // TOUT EST BON POUR AVOIR NOTRE OBJET PDO LES ZAMI(E)S !
        // PDO n'est appelé qu'UNE SEULE FOIS !!!
        return $this->pdo;
    }  
    
    /**
     * gère la requête de lecture avec plusieurs résultats
     *
     * @param string $statement
     * @param array $params
     * @return array
     */
    public function selectAll($statement, $params=[]): array
    {
        $sql = $this->getPDO( )->prepare($statement);
        $sql->execute($params);       
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    /**
     * gère la requête de lecture avec un seul résultat
     *
     * @param string $statement
     * @param array $params
     * @return array
     */
    public function select($statement, $params=[]): array
    {
        $sql = $this->getPDO( )->prepare($statement);
        $sql->execute($params);       
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function query($statement, $params=[]){
        $sql = $this->getPDO( )->prepare($statement);
        $sql->execute($params);       
        return $this->getPDO();
    }
}