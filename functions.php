<?php
require 'Connection.php';
class Functions extends Connection
{

    function addTo($name, $email, $message)
    {
        Connection::openConnection();
        $db = Connection::$conn->prepare('INSERT INTO contacts (name, email, message) VALUES ((:name), (:email), (:message))');
        $db->bindParam(':name', $name);
        $db->bindParam(':email', $email);
        $db->bindParam(':message', $message);
        $db->execute();
        return (true);
    }

    function read()
    {
        Connection::openConnection();
        $sql = 'SELECT * FROM contacts';
        foreach (Connection::$conn->query($sql) as $row) {
            echo "ID: $row[id] | name: $row[name] | e-mail: $row[email] | message: $row[message] |
            <a href='edit.php?edit=$row[id]'>edit</a>
            <a href='delete.php?del=$row[id]'>delete</a><br />";
        }
    }

    function delete()
    {
        Connection::openConnection();
        if (isset($_GET['del'])) {
            $id = $_GET['del'];
            $sql = "DELETE FROM contacts WHERE id='$id'";
            Connection::$conn->query($sql) or die("Failed");
            echo "Query deleted succesfully, go <a href='read.php'>back</a>";
        }
        if (isset($_GET['all'])) {
            $sql = "DELETE FROM contacts";
            Connection::$conn->query($sql) or die("Failed");
            echo "Query deleted everything, go <a href='read.php'>back</a>";
        }
    }

    // TODO: make edit
    // function edit()
    // {
    //     Connection::openConnection();
    //     if (isset($_GET['edit'])) {
    //         $id = $_GET['edit'];
    //         // $res = mysqli_query($this->conn, "SELECT * FROM contacts WHERE id='$id'");
    //         // $this->row = mysqli_fetch_array($res);
    //         $sql = "SELECT * FROM contacts WHERE id='$id'";
    //         $query = Connection::$conn->query($sql) or die("Failed");
    //         $row = $query->fetch(Connection::$conn->FETCH_ASSOC);
    //     }
    //     if (isset($_POST['name']) && isset($_POST['email'])) {
    //         $name = $_POST['name'];
    //         $email = $_POST['email'];
    //         $message = $_POST['message'];
    //         $id = $_POST['id'];
    //         $sql = "UPDATE contacts SET name='$name', email='$email', message='$message' WHERE id='$id'";
    //         Connection::$conn->query($sql) or die("Failed");
    //         echo "<meta http-equiv='refresh' content='0;url=read.php'>";
    //     }
    // }
}
