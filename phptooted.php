<?php
if(isset($_POST['submit'])){
    $xmlDoc = new DOMDocument("1.0","UTF-8");
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load('tooted.xml');
    $xmlDoc->formatOutput = true;

    $xml_root = $xmlDoc->documentElement;
    $xmlDoc->appendChild($xml_root);

    $xml_toode = $xmlDoc->createElement("toode");
    $xmlDoc->appendChild($xml_toode);

    $xml_root->appendChild($xml_toode);

    unset($_POST['submit']);
    foreach($_POST as $voti=>$vaartus){
        $kirje = $xmlDoc->createElement($voti,$vaartus);
        $xml_toode->appendChild($kirje);
    }
    $xmlDoc->save('tooted.xml');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toote lisamine</title>
</head>

<body>
<h2>Toote sisestamine</h2>
<table>
    <form action="" method="post" name="vorm1">
        <tr>
            <td><label for="nimetus">Toote nimetus:</label></td>
            <td><input type="text" name="nimetus" id="nimetus" autofocus></td>
        </tr>
        <tr>
            <td><label for="kirjeldus">Kirjeldus:</label></td>
            <td><input type="text" name="kirjeldus" id="kirjeldus"></td>
        </tr>
        <tr>
            <td><label for="hind">Hind:</label></td>
            <td><input type="text" name="hind" id="hind"></td>
        </tr>
        <tr>
            <td><input type="submit" name="submit" id="submit" value="Sisesta"></td>
            <td></td>
        </tr>
    </form>
</table>

</body>
</html>
