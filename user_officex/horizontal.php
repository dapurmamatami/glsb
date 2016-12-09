<style>
ul li {
    float:center;
}
ul li.break {
    clear: right;
}
</style>

sdfsdfs

<ul>
<?php
$i = 0;
foreach ($response->items->item as $value) : ?>
<li<?php if ( $i % 3 == 0 ) echo ' class="break"' ?>>
    <?php echo "<img src='".$value->imageUrl."' width=200><br>"; ?>
    <?php echo $value->description ?>
    aaa
</li>
<?php $i++; // Increment counter
endforeach ?>
</ul>

