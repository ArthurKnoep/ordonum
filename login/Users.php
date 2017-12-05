<?php

class Users
{
    /*
     * class construct
     * 
     * @params $Database object
     * @return void
     */
    public function __construct($Database){
        $this->DB = $Database;
    }
    
    /* isDataExist
     * 
     * Check if Data exists
     * 
     * @params $array array Infos about user
     * @return TRUE if exist in the table else FALSE
     */
    private function isDataExist($array)
    {
        $tab = array(
            'mail' => $array['mail']
        );
        
        $req = $this->DB->prepare('SELECT * FROM user WHERE mail=:mail');
        $req->execute($tab);
        $stock = $req->fetchAll();
        if (count($stock) > 0)
            return TRUE;
        else
            return FALSE;
    }
    
    /* addUser
     * 
     * Add a user in the table user in the bdd with infos given in $array
     * 
     * @params $array array All the infos about the user
     * @return void
     */
    public function addUser($array)
    {        

        if (!empty($array))
        {
            if (isset($array['firstName']) && isset($array['lastName']) && isset($array['mail']) && isset($array['passwd']) && isset($array['type']) && isset($array['sexe']))
            {
                if (filter_var($array['mail'], FILTER_VALIDATE_EMAIL) != FALSE)
                {
                    if ($this->isDataExist($array) == FALSE)
                    {
                        $insc = array(
                            'firstName' => $array['firstName'],
                            'lastName' => $array['lastName'],
                            'mail' => $array['mail'],
                            'passwd' => $array['passwd'],
                            'type' => $array['type'],
                            'sexe' => $array['sexe'],
                        );
                    $sql = 'INSERT INTO user (firstName, lastName, mail, passwd, type, sexe) VALUES (:firstName , :lastName , :mail , :passwd , :type , :sexe)';
                    $req = $this->DB->prepare($sql);
                    $req->execute($insc);
                    }
                }
            }
        }
    }
    
    /* editUser
     * 
     * Edit infos in the table user given in $array
     * 
     * @params $array array Infos to edit the user in the table
     * @return void
     */
    public function editUser($array)
    {
        if (!empty($array) && isset($array['idUser']) == TRUE)
        {
            $sql = 'UPDATE user SET ';
            
            if (isset($array['firstName']) == TRUE)
                $sql .= 'firstName=:firstName, ';
            
            if (isset($array['lastName']) == TRUE)
                $sql .= 'lastName=:lastName, ';
            
            if (isset($array['mail']) == TRUE)
                $sql .= 'mail=:mail, ';
            
            if (isset($array['passwd']) == TRUE)
                $sql .= 'passwd=:passwd, ';
            
            if (isset($array['type']) == TRUE)                
                $sql .= 'type=:type, ';
            
            if (isset($array['sexe']) == TRUE)
                $sql.= 'sexe=:sexe, ';
            
            $sql = rtrim($sql, ', ');
            $sql .= ' WHERE idUser=:idUser';
            var_dump($sql);
            $req = $this->DB->prepare($sql);
            $req->execute($array);
        }
    }
    
    /* delUser
     *
     * Delete $id_user
     * 
     * @params $id_user int User unique id
     * @return void
     */
    public function delUser($idUser)
    {
        if (isset($idUser) == TRUE)
        {
            $sql = 'DELETE FROM user WHERE idUser=:idUser';
            $req = $this->DB->prepare($sql);
            $req->bindParam(":idUser", $idUser);
            $req->execute();
        }
    }
    
    /* getUserInfo
     *
     * Get the insensitives infos from the user
     * 
     * @params $id_user int User unique id
     * @return object with infos
     */
    public function getUserInfo($iUser)
    {
        if (isset($idUser) == TRUE)
        {
            $sql = 'SELECT idUser, firstName, lastName, mail, type, sexe FROM user WHERE idUser=:idUser';
            $req = $this->DB->prepare($sql);
            $req->bindParam(":idUser", $idUser);
            $req->execute();
            $stock = $req->fetch();
            return $stock;
        }
    }
}
?> 
