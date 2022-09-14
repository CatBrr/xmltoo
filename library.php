<?php
$xml=simplexml_load_file("books.xml");
function getBooks($xml){
    $array=getBook($xml);
    return $array;
}
function getBook($books){
    $result=array($books);
    $book=$books->book;
    if (empty($book)) {
        return $result;
    }
    foreach ($book as $bok){
        $array=getBook($bok);
        $result=array_merge($result,$array);
    }
    return $result;
}
function searchByBookGenre($searchWord){
    global $books;
    $result=array();
    foreach($books as $book){
        if(substr(strtolower($book->description->genre), 0,
                strlen($searchWord))==strtolower($searchWord)){
            array_push($result, $book);
        }
    }
    return $result;
}
function searchByBookAuthor($searchWord){
    global $books;
    $result=array();
    foreach($books as $book){
        if(substr(strtolower($book->author), 0,
                strlen($searchWord))==strtolower($searchWord)){
            array_push($result, $book);
        }
    }
    return $result;
}

$books=getBooks($xml);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library php</title>
</head>
<body>
 <h1>Library</h1>
 <form action="?" method="post">
     <input type="radio" name="searchBy" value="bookgenre" id="bookgenre" checked>
     <label for="bookgenre">book genre</label>
     <input type="radio" name="searchBy" value="bookauthor" id="bookauthor">
     <label for="bookauthor">book author</label>
     <br>
     <input type="text" name="search" placeholder="search word">
     <button>OK</button>
 </form>
 <table border="1">
     <tr>
         <th>Title</th>
         <th>Author</th>
         <th>Publication</th>
         <th>Genre</th>
         <th>Price</th>
         <th>Description</th>
     </tr>
         <?php
         if(!empty($_POST["search"])){
         $radiobutton=$_POST["searchBy"];
         if($radiobutton== "bookgenre"){
             $result=searchByBookGenre($_POST["search"]);
         }
         else if($radiobutton== "bookauthor"){
             $result=searchByBookAuthor($_POST["search"]);
         }
         // sama tabel
         foreach ($result as $book) {
             echo "<tr>";
             echo "<td>".$book->title."</td>";
             echo "<td>".$book->author."</td>";
             echo "<td>".$book->description->publish_date."</td>";
             echo "<td>".$book->description->genre."</td>";
             echo "<td>".$book->price."</td>";
             echo "<td>".$book->description->desc."</td>";
             echo "</tr>";
            }
         }
         else{
            foreach ($books as $book){
             echo "<tr>";
             echo "<td>".$book->title."</td>";
             echo "<td>".$book->author."</td>";
             echo "<td>".$book->description->publish_date."</td>";
             echo "<td>".$book->description->genre."</td>";
             echo "<td>".$book->price."</td>";
             echo "<td>".$book->description->desc."</td>";
             echo "</tr>";
            }
         }

         ?>
 </table>
</body>
</html>
