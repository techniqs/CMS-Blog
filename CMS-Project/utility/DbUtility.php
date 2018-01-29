<?php

namespace utility;


use model\Blog;
use model\User;

class DbUtility
{

    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = 'root123';
    private $db_name = 'cms-database';
    private $mysqli;



    /**
     * DbUtility constructor to initiate the singleton db_Instance
     */
    public function __construct()
    {


        $this->mysqli = new \mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

    }


    /**
     * @return \mysqli
     */
    public function getMysqli(): \mysqli
    {
        return $this->mysqli;
    }



    // Insert
    public function u_insert(User $user)
    {
        /* Prepared statement, stage 1: prepare */
        if (!($stmt = $this->mysqli->prepare("INSERT INTO users (username, password, email,adminrights) VALUES (?, ?, ?,?)"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }


        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("sssi", $user->getUsername(), $user->getPassword(), $user->getEmail(), $user->getAdminrights())) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();

        return $stmt;
    }


    public function u_delete($username)
    {
        if (!($stmt = $this->mysqli->prepare("Delete from users where username=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $username)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();

    }


    public function u_updateName($usernameOld, $usernameNew)
    {
        if (!($stmt = $this->mysqli->prepare("Update users set username =? where username=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ss", $usernameNew, $usernameOld)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }

    public function u_updatePw($username, $passwordNew)
    {
        if (!($stmt = $this->mysqli->prepare("Update users set password =? where username=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ss", $passwordNew, $username)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }

    public function u_updateRights($username, $adminrightsNew)
    {
        if (!($stmt = $this->mysqli->prepare("Update users set adminrights=? where username=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("is", $adminrightsNew, $username)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }


    public function u_updateEmail($username, $emailNew)
    {
        if (!($stmt = $this->mysqli->prepare("Update users set email=? where username=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ss", $emailNew, $username)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }

    public function u_lookForUser($newusername)
    {
        $sql = "Select username from Users";

        $result = $this->mysqli->query($sql);


        while ($row = $result->fetch_assoc()) {
            foreach ($row as $value) {
                if ($newusername == $value) {
                    return true;
                }

            }

        }

        return false;

    }


    public function u_select()
    {
        $sql = "Select * from Users";
        $result = $this->mysqli->query($sql);

        return $result;
    }
    public function b_select(){
        $sql = "Select * from blogs";
        $result = $this->mysqli->query($sql);

        return $result;
    }


    public function b_selectId($id){
        $sql = "Select * from blogs WHERE id = ".$id;

        $result = $this->mysqli->query($sql);

        return $result;
    }





    public function c_delete($id){
        if (!($stmt = $this->mysqli->prepare("Delete from childblogs where childId=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();

    }


    public function c_insert($parentId,$childId,$position){
        /* Prepared statement, stage 1: prepare */
        if (!($stmt = $this->mysqli->prepare("INSERT INTO childblogs (parentId,childID,position) VALUES (?, ?, ?)"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }


        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ssi",$parentId,$childId,$position)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();

        return $stmt;

    }
    public function c_select(){
        $sql = "Select * from childblogs";
        $result = $this->mysqli->query($sql);

        return $result;
    }

    public function c_selectParentId($childId){

        if (!($stmt = $this->mysqli->prepare("Select parentId from childblogs where childId=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $childId)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->bind_result($parentId)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        $stmt->fetch();
        /* close statement */
        $stmt->close();


        return $parentId;
    }
    public function b_selectTitle($id){
        if (!($stmt = $this->mysqli->prepare("Select title from blogs where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->bind_result($title)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        $stmt->fetch();
        /* close statement */
        $stmt->close();


        return $title;
    }


    public function b_updateActive($id,$active){

        if (!($stmt = $this->mysqli->prepare("Update blogs set active =? where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("is", $active, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }
    public function b_updateTitle($id,$title){

        if (!($stmt = $this->mysqli->prepare("Update blogs set title =? where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ss", $title, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }
    public function b_updateText($id,$text){

        if (!($stmt = $this->mysqli->prepare("Update blogs set text =? where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ss", $text, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }
    public function b_updateDateBeg($id,$dateBeg){

        if (!($stmt = $this->mysqli->prepare("Update blogs set dateBeg =? where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ss", $dateBeg, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }
    public function b_updateDateEnd($id,$dateEnd){

        if (!($stmt = $this->mysqli->prepare("Update blogs set dateEnd =? where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ss", $dateEnd, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }
    public function b_updateImage($id,$image){

        if (!($stmt = $this->mysqli->prepare("Update blogs set image =? where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ss", $image, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }
    public function b_updateFiles($id,$files){

        if (!($stmt = $this->mysqli->prepare("Update blogs set files =? where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ss", $files, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }

    public function b_updatePosition($id,$position){

        if (!($stmt = $this->mysqli->prepare("Update blogs set position =? where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("is", $position, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }
    public function c_updatePosition($id,$position){

        if (!($stmt = $this->mysqli->prepare("Update childBlogs set position =? where childId=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("is", $position, $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }

    public function c_updatePositionWithParents($childId,$parentId,$position){

        if (!($stmt = $this->mysqli->prepare("Update childBlogs set position =?, parentID=? where childId=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("iss", $position, $parentId,$childId)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }


    public function b_trySelect($id){

        include ("..\model\Blog.php");
        if (!($stmt = $this->mysqli->prepare("Select * from blogs where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->bind_result($id,$author,$title,$text,$image,$files,$active,$dateBeg,$dateEnd,$position)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        $stmt->fetch();
        /* close statement */
        $stmt->close();

        $blog = new Blog($id,$author,$title,$text,$image,$files,$active,$dateBeg,$dateEnd,$position);

        return $blog;
    }

    public function u_query_password($username)
    {
        if (!($stmt = $this->mysqli->prepare("Select password from Users where username=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $username)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->bind_result($password)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->fetch();
        /* close statement */
        $stmt->close();

        return $password;
    }

    public function u_query_adminRights($username)
    {
        if (!($stmt = $this->mysqli->prepare("Select adminrights from Users where username=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $username)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->bind_result($adminrights)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->fetch();
        /* close statement */
        $stmt->close();

        return $adminrights;
    }

    public function b_position($id){
        if (!($stmt = $this->mysqli->prepare("Select position from blogs where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->bind_result($position)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->fetch();
        /* close statement */
        $stmt->close();

        return $position;

    }


    // Insert
    public function b_insert(Blog $blog)
    {
        /* Prepared statement, stage 1: prepare */
        if (!($stmt = $this->mysqli->prepare("INSERT INTO blogs (id,author,title, text, image, files,active, datebeg ,dateEnd, position) VALUES (?,?,?,?,?,?,?,?,?,?)"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        //PHP is whining about not being able to pass the data by reference as a result.
        $id = $blog->getId();
        $author = $blog->getAuthor();
        $title = $blog->getTitle();
        $text = $blog->getText();
        $image = $blog->getImage();
        $files = $blog->getFiles();
        $active = $blog->getActive();
        $dateBeg = $blog->getDateBeg();
        $dateEnd = $blog->getDateEnd();
        $position=$blog->getPosition();

        //$dateBeg->format('Y-m-d H:i:s');
        //$dateEnd->format('Y-m-d H:i:s');
        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("ssssssisss", $id, $author, $title, $text, $image, $files, $active, $dateBeg, $dateEnd,$position)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();
    }


    public function b_delete($id)
    {
        if (!($stmt = $this->mysqli->prepare("Delete from blogs where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* close statement */
        $stmt->close();

    }

    public function b_selectPOS($id){

        if (!($stmt = $this->mysqli->prepare("Select position from blogs where id=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->bind_result($position)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        $stmt->fetch();
        /* close statement */
        $stmt->close();


        return $position;
        }

    public function c_selectPOS($id){

        if (!($stmt = $this->mysqli->prepare("Select position from childBlogs where childId=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->bind_result($position)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }


        $stmt->fetch();
        /* close statement */
        $stmt->close();


        return $position;
    }

    public function c_selectAllWithParentID($parentId){
        if (!($stmt = $this->mysqli->prepare("Select position from childBlogs where parentId=?"))) {
            echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }


        /* Prepared statement, stage 2: bind and execute */
        if (!$stmt->bind_param("s", $parentId)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->bind_result($position)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->fetch();
        /* close statement */
        $stmt->close();

        return $position;

    }

        public function c_realDelete($id){

        $position= $this->c_selectPOS($id);
        $parentID=$this->c_selectParentId($id);
        $blogs=$this->c_select();
        while($row=$blogs->fetch_assoc()){
            if ($row['parentId']==$parentID){
                if ($row['position']>$position){
                    $this->c_updatePosition($row['childId'],$row['position']-1);

                }

            }
        }
        $this->c_delete($id);


        }

        public function b_realDelete($id){
            $position=$this->b_selectPOS($id);
            $blogs=$this->b_select();
            while ($row = $blogs->fetch_assoc()){
                    if ($row['position']>$position){
                        $this->b_updatePosition($row['id'],$row['position']-1);
                    }

            }
            $this->b_delete($id);
    }


    public function b_selectOrderPos(){

        $sql = "Select * From blogs ORDER BY position" ;

        $result = $this->mysqli->query($sql);

        return $result;

    }
    public function b_selectOnlyParents(){
        $sql="SELECT * FROM `blogs` Where position > 0 order by position";
        $result = $this->mysqli->query($sql);

        return $result;
    }


    //with c_select ez
    public function b_titleandPos(){

        $sql = "Select title,position from blogs" ;

        $result = $this->mysqli->query($sql);

        return $result;
    }



    /*
    Function: close
    Purpose: Close the connection
    */
    function closingConnection()
    {
        mysqli_close($this->mysqli);

    }

}

?>