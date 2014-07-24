<?php
/*
  Plugin Name: Recent Posts By Ali
  https://github.com/SayedZahirAli/WordPress-Recent-Posts/new/master
  Description: A Recent Post with images having photo effect and Shortcode Support.
  Version: 1.0.0
  Author: Sayed Zahir Ali
  Author URI: http://about.me/sayedzahirali/
 */

// Add CSS File to document
define("PLUGINDIR", plugins_url());

add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_styles() {
    //wp_register_style('hover', PLUGINDIR . '/style_hover.css', array(), '3', 'all');
    wp_register_style('hover', plugins_url('assets/style_hover.css', __FILE__));
    wp_enqueue_style('hover');
    wp_register_style('bootstrap', plugins_url('assets/bootstrap.min.css', __FILE__));
    wp_enqueue_style('bootstrap');
    wp_register_script('bootstrap', plugins_url('RecentPosts/assets/bootstrap.min.js'), array('jquery'), '1', false);
    wp_enqueue_script('bootstrap');
}

//ShortCode
function recent_posts($atts, $content = null) {
    $count = $atts['count'];
    $category = $atts['category_id'];
    $perline = $atts['per_line'];
    $cat = '';
    if ($category == "All") {
        $cat = 0;
    } else {
        $cat = $category;
    }
    $numberpost = $count;
    $args = array('numberposts' => $numberpost, 'category' => $cat);
    $recent_posts = wp_get_recent_posts($args);
    ?>
    <div class="container-fluid">
        <div class="title">
            <h2>Recent Posts:</h2>
        </div>
        <div class="row">
            <?php
            $cnt = 0;
            $result = count($recent_posts);
            foreach ($recent_posts as $recent) :
                $img = wp_get_attachment_image_src(get_post_thumbnail_id($recent["ID"]), 'single-post-thumbnail');
                $image = $img[0];
                ?>
                <div class="col-md-4">
                    <div class="view view-first">
                        <img src="<?php echo $image ?>" height="145" width="200">
                        <div class="mask">
                            <h2><?php echo esc_attr($recent["post_title"]); ?></h2>
                        </div>
                    </div>
                    <a href="<?php echo get_permalink($recent["ID"]); ?>" title="<?php echo esc_attr($recent["post_title"]); ?>" ><?php echo $recent["post_title"]; ?></a>
                </div>
                <?php
                $cnt++;
                if ($cnt % 3 == 0) {
                    echo '</div><div class="row">';
                }
                ?>
            <?php endforeach; ?>
        </div>  
    </div>
    <?php
}

add_shortcode('recentposts', 'recent_posts');
?>
