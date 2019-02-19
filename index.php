<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Ratings App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class = "container">
      <div class="jumbotron">
        <h1>Ratings Application</h1>
        <form action="" method = "get">
          <p>Enter item number:</p>
          <input name="id" type ="text"/>
          <br><br>
          <input type="submit" name="ratings" value="Display Ratings" class="btn btn-info"/>
          <input type="submit" name="reviews" value="Display Reviews" class="btn btn-info"/>
        </form>
      </div>
      <?php 
        #if ratings average button is clicked
        if(isset($_GET['ratings'])){
          $url = 'http://localhost:3000/api/ratingaverage/json?id='.$_GET['id'];
          $ch = curl_init($url); #api call
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $response = curl_exec($ch);
          $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);

          if($httpCode == 404)
            echo 'Item '.$_GET['id'].' not found';
          else {
            $ratingsData = json_decode($response)->item;
            #display results
            echo '<h2>RATINGS AVERAGE FOR ITEM #'.$_GET['id'].'</h2>';
            echo '<p><b>ITEM ID#</b> : '.$ratingsData->id.'</p>';
            echo '<p><b>NAME</b> : '.$ratingsData->name.'</p>';
            echo '<p><b>AVERAGE</b> : '.$ratingsData->average.'</p>';
            echo '<p><b>RATINGS COUNT</b> : '.$ratingsData->ratingsCount.'</p>';
          }
        }
      ?>
       <?php 
        #if reviews button is clicked
        if(isset($_GET['reviews'])){
          $url = 'http://localhost:3000/api/reviews/json?id='.$_GET['id'];
          $ch = curl_init($url); #api call
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $response = curl_exec($ch);
          $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);

          if($httpCode == 404)
            echo 'Item '.$_GET['id'].' not found';
          else {
            $itemInfo = json_decode($response); 
            $reviews = $itemInfo->item->reviews; #store all reviews for the item
            #display reviews
            echo '<h2>REVIEWS FOR ITEM # '.$_GET['id'].'</h2>';
            foreach ($reviews as $review){ 
              echo "<p><b>REVIEW ID#</b>: ".$review->id."</p>";
              echo "<p><b>TITLE:</b> ".$review->title."</p>";
              echo "<p><b>AVERAGE:</b> ".$review->average."</p>";
              echo "<p><b>COMMENT:</b> ".$review->comment."</p>";
              echo "<p><b>REVIEWED BY: </b>".$review->reviewedBy."</p>";
              echo "<p><b>DEPARTMENT: </b>".$review->department."</p>";
              echo "<p><b>CREATED DATE:</b>".$review->createdDate."</p>";
              echo "<hr>";
            };
          }
        }
      ?>
    </div>
  </body>
</html>

