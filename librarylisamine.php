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
function SumPrice(){
    global $books;
    $sum=0;
    foreach($books as $book){
        $sum=$sum+$book->price;
    }
    return $sum;
}
function addToXML(){
        $xmlDoc = new DOMDocument("1.0", "UTF-8");
        $xmlDoc->preserveWhiteSpace = false;
        $xmlDoc->load('books.xml');
        $xmlDoc->formatOutput = true;

        $xml_root = $xmlDoc->documentElement;
        $xmlDoc->appendChild($xml_root);

        $xml_book = $xmlDoc->createElement("book");
        $xmlDoc->appendChild($xml_book);
        unset($_POST['submit']);
        $xml_root->appendChild($xml_book);
        $xml_book->appendChild($xmlDoc->createElement("author", $_POST['author']));
        $xml_book->appendChild($xmlDoc->createElement("title", $_POST['title']));
        $xml_book->appendChild($xmlDoc->createElement("price", $_POST['price']));
        $xml_desc = $xmlDoc->createElement("description");
        $xml_desc->appendChild($xmlDoc->createElement("genre", $_POST['genre']));
        $xml_desc->appendChild($xmlDoc->createElement("publish_date", $_POST['publish_date']));
        $xml_desc->appendChild($xmlDoc->createElement("desc", $_POST['desc']));
        $xml_book->appendChild($xml_desc);
        $xmlDoc->save('books.xml');

}
if(!empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['price']) && !empty($_POST['genre']) && !empty($_POST['publish_date']) && !empty($_POST['desc'])) {
    addToXML();
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
 <h2>Book adding</h2>
 <table>
     <form action="" method="post">
         <tr>
             <td><label for="author">Author:</label></td>
             <td><input type="text" name="author" id="author"></td>
         </tr>
         <tr>
             <td><label for="title">Title:</label></td>
             <td><input type="text" name="title" id="title" autofocus></td>
         </tr>
         <tr>
             <td><label for="price">Price:</label></td>
             <td><input type="text" name="price" id="price"></td>
         </tr>
         <tr>
             <td><label for="publish_date">Publicate:</label></td>
             <td><input type="text" name="publish_date" id="publish_date"></td>
         </tr>
         <tr>
             <td><label for="genre">Gerne:</label></td>
             <td><input type="text" name="genre" id="genre"></td>
         </tr>
         <tr>
             <td><label for="desc">Description:</label></td>
             <td><input type="text" name="desc" id="desc"></td>
         </tr>
         <tr>
             <td><input type="submit" name="submit" id="submit" value="add"></td>
             <td></td>
         </tr>
     </form>
 </table>
 <h2>search</h2>
 <form action="?" method="post">
     <input type="radio" name="searchBy" value="bookgenre" id="bookgenre" checked>
     <label for="bookgenre">book genre</label>
     <input type="radio" name="searchBy" value="bookauthor" id="bookauthor">
     <label for="bookauthor">book author</label>
     <br>
     <input type="text" name="search" placeholder="search word">
     <button>OK</button>
 </form>
 <table border="1px black solid">
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
             echo "<tr>";
             echo "<th>Summary books</th>";
             echo "<td>".(count($books)-1)."</td>";
             echo "<td> </td>";
             echo "<th>Summary price</th>";
             echo "<td>".(SumPrice())."</td>";
             echo "<td> </td>";
             echo "</tr>";
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
             echo "<tr>";
             echo "<th>Summary books</th>";
             echo "<td>".(count($books)-1)."</td>";
             echo "<td> </td>";
             echo "<th>Summary price</th>";
             echo "<td>".(SumPrice())."</td>";
             echo "<td> </td>";
             echo "</tr>";

         }

         ?>
 </table>
</body>
</html>
