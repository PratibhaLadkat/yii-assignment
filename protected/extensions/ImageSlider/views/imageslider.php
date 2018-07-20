<div class="w3-content w3-display-container">
    <?php foreach($images as $image) {?>
        <img class="mySlides" src="<?php echo $imageBasePath .'/'. $image;?>" style="width:100%">
    <?php
    }
    ?>
    <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
    <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
</div>
<script type="text/javascript">
   showDivs(slideIndex);
</script>
