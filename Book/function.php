<?php
error_reporting(0);
require '../inconn/coon.php';

function error422($message)
{
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");

    echo json_encode($data);
    exit();
}


function storeBook($bookinput)
{
    global $connect;

    $name = mysqli_real_escape_string($connect, $bookinput['name']);
    $author = mysqli_real_escape_string($connect, $bookinput['Author']);
    $number = mysqli_real_escape_string($connect, $bookinput['NumberOfPages']);


    if (empty(trim($name))) {

        return error422('Enter Your name');
    } elseif (empty(trim($author))) {


        return error422('Enter Your author');
    } elseif (empty(trim($number))) {



        return error422('Enter Your NumberOfPages');
    } else 
  {

    
    $query = "INSERT INTO `books`( `name`, `Author`, `NumberOfPages`) VALUES ('$name','$author','$number')";

    $result = mysqli_query($connect, $query);



    if ($result) {
        $data = [
            'status' => 201,
            'message' => 'Book Created Successfully',
        ];
        header("HTTP/1.0 201 Created");

        return json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");

        return json_encode($data);
    }

   }


}


function getBookList()
{

    global $connect;

    $query = "select * from books";
    $query_run = mysqli_query($connect, $query);

    if ($query_run) {

        if (mysqli_num_rows($query_run) > 0) {

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Book List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");

            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Book Found',
            ];
            header("HTTP/1.0 404 No Book Found");

            return json_encode($data);
        }




    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");

        return json_encode($data);
    }


}

function getbook($bookParams)
{
    global $connect;
    if ($bookParams['id'] == null) {

        return error422("Enter your book id");
    }
    $bookid = mysqli_real_escape_string($connect, $bookParams['id']);

    $query = "SELECT * FROM books WHERE id='$bookid' limit 1";
    $result = mysqli_query($connect, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) 
        {
            $res = mysqli_fetch_assoc($result);
            $data = [
                'status' => 200,
                'message' => 'Book  Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");

            return json_encode($data);
        } 
        else 
        {
            $data = [
                'status' => 404,
                'message' => 'No book found',
            ];
            header("HTTP/1.0 404 No book found");

            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");

        return json_encode($data);
    }

}


function updateBook($bookinput, $bookParams)
{
    global $connect;

    if (!isset($bookParams['id'])) {
        return error422('Book id not found in URL');
    }elseif ($bookParams['id']== null) {
        return error422('Enter the book id');
    }

    $bookId = mysqli_real_escape_string($connect, $bookParams['id']);

    $name = mysqli_real_escape_string($connect, $bookinput['name']);
    $author = mysqli_real_escape_string($connect, $bookinput['Author']);
    $number = mysqli_real_escape_string($connect, $bookinput['NumberOfPages']);

    if (empty(trim($name))) {
        return error422('Enter the book name');
    } elseif (empty(trim($author))) {
        return error422('Enter the author');
    } elseif (empty(trim($number))) {
        return error422('Enter the number of pages');
    } else {
        $query = "UPDATE `books` SET `name`='$name', `Author`='$author', `NumberOfPages`='$number' WHERE id='$bookId' LIMIT 1";
        $result = mysqli_query($connect, $query);

        if ($result) {
            $data = [
                'status' => 201,
                'message' => 'Book updated successfully',
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}


function deletebook($bookParams){
    global $connect;

    if (!isset($bookParams['id'])) {
        return error422('Book id not found in URL');
    }elseif ($bookParams['id'] == null) {
        return error422('Enter the book id');
    }
    $bookId = mysqli_real_escape_string($connect, $bookParams['id']);
    
    $query = "DELETE FROM `books` WHERE id='$bookId' limit 1";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'book Delete Successfully',
        ];
        header("HTTP/1.0 200 OK");

        return json_encode($data);
    }else {
        $data = [
            'status' => 404,
            'message' => 'No book found',
        ];
        header("HTTP/1.0 404 No Found");

        return json_encode($data);
    }


}




?>