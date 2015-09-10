<?php defined('C5_EXECUTE') or die("Access Denied.")?>

<div class="mylab-typer" id="mylab-typer-<?php echo $bID ?>">
<span id="typer-<?php echo $bID?>" class="mylab_typer"></span><span class="typer-first-sentence"><?php echo $firstSentence ?></span>	<<?php echo $tag ?>>
	<<?php echo $tag ?> class="cd-headline rotate-1">
		<span><?php echo $setenceStart ?></span>
		<span class="cd-words-wrapper">
			<?php foreach ($comaSeparatedSentence as $key => $value) :?>
				<b <?php if($key == 0): ?> class="is-visible"<?php endif ?>><?php echo $value ?></b>
			<?php endforeach; ?>      
		</span>
    <?php echo $setenceEnd ?>
	</<?php echo $tag ?>>
</div>

<script>
	$(document).ready(function(){
		$("#mylab-typer-<?php echo $bID ?>").MyLabTyper({

		});   
	}) 
</script>