<style>
	svg {
		z-index: 99;
	}
	path {
		fill: rgba(255, 255, 255, 0);
	}
      path:hover:not(.no-rental) {
        fill: rgba(255, 255, 255, 0.5);
        stroke: #eee;
        stroke-width: 1px;
        cursor:pointer;
      }
	.no-rental {
		fill:rgba(0,0,0,0.3);
		stroke: rgba(0,0,0,.1);
		stroke-width: 1px
	}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<div style="display: none" id="anchors">
	<?php foreach($unitLinks as $key=>$link) {?>
	<a class="rental-link" href="<?php echo $link; ?>" id="<?php echo $key; ?>"></a>
	<?php } ?>
</div>

<div id="sitemap-page" style="display: flex; justify-content:center">
  <?php echo $svg_file; ?>
</div>

<script>
  const sites = $('path');
  sites.each(function() {
    const id = $(this).attr("id").substring(4);
	const link = $("#" + id);
	  if (!link.length) {
		  $(this).addClass("no-rental");
	  } else {
	 	 jQuery(this).on("click", function() {window.location.href=$("#" + id).attr("href")});
	  }
  })
</script>