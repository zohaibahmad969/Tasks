<?php get_header(); ?>
<div class="single-tickets">
<?php rdsn_banner(); ?>

<div class="row-mid"><div class="container">

<?php
	$show_pricing = get_field('opt_show_prices','option');
	$pricing_text = get_field('opt_prices_fallback_text','option');
	if ($show_pricing == 'yes'):
?>
<div id="pricing">
<?php if(have_rows('tables')): while ( have_rows('tables') ) : the_row(); ?>
<div class="table-title animated anim-up"><h2><?php the_sub_field('table_name'); ?></h2></div>
<?php if( have_rows('pricing_category') ): ?>
<?php  while( have_rows('pricing_category') ): the_row(); $table_price_header = ''; ?>
<?php if(get_sub_field('show_category_row') != 'No'){ ?>
    <div class="category group">
        <div class="left border-box"><?php the_sub_field('category_name'); ?></div>
        <div class="right">
            <?php $table_price_header = '<div class="price-title  group">
                <div class="col-sm first">&nbsp;</div><div class="col-sm">'.(( get_sub_field('pricing_name_1') )?get_sub_field('pricing_name_1'):'&nbsp;').'</div><div class="col-sm">'.(( get_sub_field('pricing_name_2') )?get_sub_field('pricing_name_2'):'&nbsp;').'</div><div class="col-sm last">&nbsp;</div>
            </div>';
            echo $table_price_header;
            ?>
        </div>
    </div>
<?php } //if(get_sub_field('show_category_row') != 'No'){ ?>
<div class="pricing-wrapper">
<?php
if( have_rows('products') ): while( have_rows('products') ): the_row(); ?>
<div class="content-pricing group">
    <div class="left border-box">
        <h4><?php the_sub_field('product_name'); ?></h4>
        <?php if( get_sub_field('description') ){ echo '<div class="description border-box">'.get_sub_field('description').'</div>'; } ?>
        <?php $row_class=''; if( get_sub_field('description') ){ $row_class=' with_desc'; } ?>
    </div>
	<?php if( have_rows('prices') ): ?>
    <div class="right<?php echo $row_class; ?>  border-box">
        <?php 
        echo '<div class="mini-mobile">'.$table_price_header.'</div>';
        while( have_rows('prices') ): the_row(); ?>
            <div class="price-row">
                <div class="col-sm price-note"><?php the_sub_field('price_note'); ?></div>
                <div class="col-sm price"><?php the_sub_field('price_1'); ?></div>
                <div class="col-sm price"><?php the_sub_field('price_2'); ?></div>
                <div class="col-sm buy-now"><?php if( get_sub_field('buy_url') ){ echo '<a href="'.get_sub_field('buy_url').'" target="_blank" class="btn-solid trans-0-3"><span>Buy Now</span></a>'; }else{ echo '&nbsp;';} ?></div>
            </div>
            <div class="price-row-mobile">
                <div class="col-sm price"><?php the_sub_field('price_1'); ?></div><div class="col-sm price"><?php the_sub_field('price_2'); ?></div><div class="col-sm price-note"><?php if (get_sub_field('price_note')) { echo '&lt; '; } ?><?php the_sub_field('price_note'); ?></div><div class="buy-now"><?php if( get_sub_field('buy_url') ){ echo '<a href="'.get_sub_field('buy_url').'" target="_blank" class="btn-solid trans-0-3"><span>Buy Now</span></a>'; }else{ echo '';} ?></div>
            </div>
        <?php endwhile; //prices?>
    </div>

<?php endif; //if( get_sub_field('prices') ): ?>
</div>
<?php endwhile; //products ?>
</div>

<?php endif; //if( get_sub_field('products') ): ?>
<?php endwhile; //pricing category ?>
<?php endif; //if( get_sub_field('pricing_category') ): ?>
	
<?php if( get_sub_field('table_footer') ){ ?>
	<div class="table-footer border-box"><?php the_sub_field('table_footer'); ?></div>
<?php } ?>
<?php
    endwhile;
else :
    // no rows found
endif;
?>
</div>
<?php else: echo '<div class="txt-large">'.$pricing_text.'</div>'; ?>
<?php endif; ?>


</div></div>

</div>
<?php get_footer(); ?>


