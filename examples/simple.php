<?php
# Get all all the faq_categories
$categories = get_categories(array(
    'orderby' => 'name',
    'order' => 'ASC',
    'taxonomy' => 'faq_category'
));

$i = 1;

# Begin loop, not THE Loop of course.
foreach ($categories as $category => $value) {
    $cat_id = $value->term_id;

    $faq_query = new WP_Query(array(
            'order' => 'ASC',
            'post_type' => 'faq',
            'posts_per_page' => 100,
            'tax_query' => array(
                array(
                    'taxonomy' => 'faq_category',
                    'terms' => $cat_id
                )
            )
        )
    )
    ?>
    <div class="faq-category" id="<?php echo $value->slug; ?>">

        <h1 class="faq-category-heading"><?php echo $value->name; ?></h1>

        <ul class="faq-list">
            <?php while($faq_query->have_posts()) : $faq_query->the_post(); ?>
                <li class="faq">
                    <h3 class="question"><?php the_title(); ?></h3>
                    <div class="answer">
                        <?php the_content(); ?>
                    </div>
                </li>
                <?php $i++; ?>
            <?php endwhile; ?>
        </ul>

        <?php wp_reset_postdata(); ?>
    </div>
<?php } // End category foreach ?>