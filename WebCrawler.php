<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<meta charset = "UTF-8">
<?php
include('simplehtmldom_1_9_1/simple_html_dom.php');
include("config/constants.php");

header('Content-Type: text/html; charset=utf-8');

$connect = new mysqli($hostname,$username,$password,$dbname) or die("DB Connection Failed");


#echo "post val : ".$_POST['addr']."<br>";

#$replaced = mb_convert_encoding($replaced,"UTF-8","auto");

/*
echo "<br><br>replaced :".$replaced."<br>";
echo "bin2hex : ".bin2hex($replaced).'<br>';
echo "bin2hex : ".bin2hex("기묘한+이야기").'<br>';
 */

#$const = "기묘한+이야기";
#it works
#$const = iconv('UTF-8','ASCII',$const);

/*
checkEncoding($_POST["addr"]);
checkEncoding($replaced);
checkEncoding("기묘한+이야기");
checkEncoding($const);
 */

#this is very important part of this program;;
$videoName = urlencode($_POST['addr']);
$recommend = urlencode( " and 넷플릭스 추천");
$addr = "https://www.google.com/search?q=" . $videoName.$recommend;

#echo $addr."<br>";


mysql_fetch($videoName,$addr);

?>

<?php

function loopThrough($addr,$videoName){
    $pageNum = 10;
    $getCount = 0;
    $sumCount = 0;
    $newAddr = "";

    $opts = array(
          'http'=>array(
                  'header'=>"User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53\r\n"
                    )
                );
     
    $context = stream_context_create($opts);

    //check if it's in db


    while(1){
        $newAddr = $addr."&start=";
        $newAddr = $newAddr.$pageNum;

        #echo "newAddr is : ".$newAddr."<br>";
        #$newAddr = "http://www.naver.com";

# access deny by google
        $htmlText = file_get_html($newAddr);
        $getCount = getCountFunc($videoName,$htmlText); 
        $sumCount = $sumCount + $getCount;

        #echo "getCount is : ".$getCount."<br>";
        if( $getCount == 0){
            break;
        }

        $pageNum += 10;


        #for access deny
        #break;
    }
    #echo "sumCount is ".$sumCount."<br>";

    #insert into db
    mysql_insert($videoName,$sumCount);

    return $sumCount; 

}


function getCountFunc($videoName,$htmlText){
    $count = 0;

    foreach($htmlText->find('div[class=BNeawe vvjwJb AP7Wnd]') as $element){
        //print lines
        #echo "element->plaintext is : ". $element->plaintext . '<br>';

        $check = $element->plaintext;
        $target1 = "추천";
        $target2 = $videoName;

        $count = $count + 1;
    }

    return $count;
}
?>

<?php
function checkEncoding($inputStr){
    $encode = array('ASCII','UTF-8','EUC-KR');
    $str_encode = mb_detect_encoding($inputStr,$encode);

    echo "input string is ".$inputStr."and encoding is ".$str_encode."<br>";

}
?>

<?php
function mysql_create(){
    $hostname = "localhost";
    $username = "cse20141508";
    $password = "cse20141508";
    $dbname = "db_cse20141508";
    $connect = new mysqli($hostname,$username,$password,$dbname) or die("DB Connection Failed");
    if($connect ){
        echo ("MySQL Server Connect Success !<br/>");
    }
    else{
        echo ("MySQL Server Connect Failed! <br/?");
    }


    $sql = "CREATE TABLE netflix_db( 
        ordernumber INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        score_count INT(6) UNSIGNED,
        eval_date TIMESTAMP
    )"; 


    if($connect -> query($sql) === TRUE){
        echo "Table orderlist created successfully<br/>";
    }else{
        echo "Error creating table: ".$connect->error."<br/>";
    }
    $connect -> close();
}

function mysql_insert($name,$count){

    $hostname = "localhost";
    $username = "cse20141508";
    $password = "cse20141508";
    $dbname = "db_cse20141508";
    $connect = new mysqli($hostname,$username,$password,$dbname) or die("DB Connection Failed");
    if($connect ){
        #echo ("MySQL Server Connect Success !<br/>");
    }
    else{
        echo ("MySQL Server Connect Failed! <br/?");
    }


#    $name = urldecode($name);
    #echo $name."<br>";

    $sql = "INSERT INTO netflix_db(name,score_count) VALUES($name,$count)";

    if($connect -> query($sql) === TRUE){
       # echo $name." is inserted successfully</br>";
    }
    else{
        echo "Error:".$sql."<br>".$connect->error."<br>";
    }

    mysqli_close($connect);

}

function mysql_fetch($name,$addr){
    
    $hostname = "localhost";
    $username = "cse20141508";
    $password = "cse20141508";
    $dbname = "db_cse20141508";
    $connect = new mysqli($hostname,$username,$password,$dbname) or die("DB Connection Failed");

    $answer =0;

    if($connect){
       # echo ("MySQL Server Connect Success !<br/>");
    }
    else{
        echo ("MySQL Server Connect Failed! <br/?");
    }

#    $name = urldecode($name);
    $name = "'".$name."'";

    $sql = "SELECT * FROM netflix_db WHERE name = $name";
    $result = $connect->query($sql);

    $row = mysqli_fetch_row($result);

    mysqli_close($connect);

    #already in the db
    if(empty($row)){
        $answer = loopThrough($addr,$name);
    }
    #not in the db
    else{
        $answer = $row[2];
    }

    evaluate($name,$answer);
}

function evaluate($name,$sumCount){
    $name = urldecode($name);
    if( $sumCount < 10){
        echo $name." is not recommended , score :".$sumCount."<br>";
    }else if($sumCount >= 10 and $sumCount <= 30){
        echo $name." has litte fun , score :".$sumCount."<br>"; 
    }else if($sumCount >30 and $sumCount <= 60){
        echo $name." is maybe fun, score :".$sumCount."<br>";
    }else if($sumCount>60 and $sumCount <80){
        echo $name." is recommended and it fun, score:".$sumCount."<br>";
    }else if($sumCount >= 80){
        echo $name." is highly recommended and it's extremely fun, score:".$sumCount."<br>";
    } 
}
?>

</body>
</html>


