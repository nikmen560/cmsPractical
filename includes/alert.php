  
  <?php function show_alert($color, $heading, $content = '')
  {
      echo "
            <div class='alert alert-$color' role='alert'>
                <h4 class='alert-heading text-center'>$heading</h4>
                <p>$content</p>
            </div>
           ";

  } 
  ?>