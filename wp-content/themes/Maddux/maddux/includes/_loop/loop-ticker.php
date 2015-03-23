<ul id="ts-news-ticker" class="slides">
    <?php
    $ts_query = (isset($atts) && ($atts['default_query'] === false)) ? new WP_Query($atts) : $wp_query;
    $atts = (isset($atts)) ? $atts : array();
    
    if($ts_query->have_posts()) : 
        while($ts_query->have_posts()) :
            $ts_query->the_post();
    ?>                        
    <li class="news-item flex-item"><?php echo ts_sticky_badge(false);?><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
    <?php
        endwhile;
    endif;
    ?>                        
</ul>
