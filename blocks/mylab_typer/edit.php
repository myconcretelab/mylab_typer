<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="form-group">
    <?php echo $form->label('setenceStart', 'Sentence Start'); ?>
    <?php  echo $form->text('setenceStart', $setenceStart); ?>

    <?php echo $form->label('comaSeparatedSentence', 'Coma Separated Sentences'); ?>
    <?php  echo $form->textarea('comaSeparatedSentence', $comaSeparatedSentence); ?>

    <?php echo $form->label('setenceEnd', 'Sentence to change'); ?>
    <?php  echo $form->text('setenceEnd', $setenceEnd); ?>
    
    <?php echo $form->label('tag', 'HTML Tag'); ?>
    <?php echo $form->select('tag', array('h1' => 'h1', 'h2' => 'h2','h3' => 'h3','h4' => 'h4', 'h5' => 'h5','h6' => 'h6', 'p' => 'p'), $tag)?>

<!--     <?php echo $form->label('class', 'Special Class'); ?>
    <?php echo $form->select('class', array(0 => 'None', 'hero' => 'Hero'), $class)?>
 -->
</div>