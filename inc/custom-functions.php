<?php
if (!class_exists('live_and_lets_fly_class')) {

    class live_and_lets_fly_class
    {

        public function __construct()
        {
            //
        }
        public function init()
        {
            add_action('airlines_add_form_fields', array($this, 'add_airlines_image'), 10, 2);
            add_action('created_airlines', array($this, 'save_airlines_image'), 10, 2);
            add_action('airlines_edit_form_fields', array($this, 'update_airlines_image'), 10, 2);
            add_action('edited_airlines', array($this, 'updated_airlines_image'), 10, 2);
            add_action('admin_enqueue_scripts', array($this, 'load_media'));
        }

        public function load_media()
        {
            wp_enqueue_media();
        }
        public function add_airlines_image($taxonomy)
        { ?>
            <div class="form-field term-group">
                <label for="airlines-image-id"><?php _e('Image', 'hero-theme'); ?></label>
                <input type="hidden" id="airlines-image-id" name="airlines-image-id" class="custom_media_url" value="">
                <div id="airlines-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary meals_hub_media_button" id="meals_hub_media_button" name="meals_hub_media_button" value="<?php _e('Add Image', 'hero-theme'); ?>" />
                    <input type="button" class="button button-secondary code_media_remove" id="code_media_remove" name="code_media_remove" value="<?php _e('Remove Image', 'hero-theme'); ?>" />
                </p>
            </div>
        <?php
        }
        public function save_airlines_image($term_id, $tt_id)
        {
            if (isset($_POST['airlines-image-id']) && '' !== $_POST['airlines-image-id']) {
                $image = $_POST['airlines-image-id'];
                add_term_meta($term_id, 'airlines-image-id', $image, true);
            }
        }
        public function update_airlines_image($term, $taxonomy)
        { ?>
            <tr class="form-field term-group-wrap">
                <th scope="row">
                    <label for="airlines-image-id"><?php _e('Airline Image', 'hero-theme'); ?></label>
                </th>
                <td>

                    <input type="hidden" id="airlines-image-id" name="airlines-image-id" value="<?php echo $image_id; ?>">
                    <div id="airlines-image-wrapper">
                        <?php $image_id = get_term_meta($term->term_id, 'airlines-image-id', true); ?>
                        <?php if ($image_id) { ?>
                            <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                            <?php // print_r($image_id) 
                            ?>
                        <?php } ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary meals_hub_media_button" id="meals_hub_media_button" name="meals_hub_media_button" value="<?php _e('Add Image', 'hero-theme'); ?>" />
                        <input type="button" class="button button-secondary code_media_remove" id="code_media_remove" name="code_media_remove" value="<?php _e('Remove Image', 'hero-theme'); ?>" />
                    </p>
                </td>
            </tr>
    <?php
        }
        public function updated_airlines_image($term_id, $tt_id)
        {
            if (isset($_POST['airlines-image-id']) && '' !== $_POST['airlines-image-id']) {
                $image = $_POST['airlines-image-id'];
                update_term_meta($term_id, 'airlines-image-id', $image);
            } else {
                update_term_meta($term_id, 'airlines-image-id', '');
            }
        }
    }
    $live_and_lets_fly_class = new live_and_lets_fly_class();
    $live_and_lets_fly_class->init();
}



// Meals Meta Boxes List

function add_meals_metaboxes()
{
    add_meta_box(
        'meals_route',
        'Route',
        'meals_route',
        'meals',
        'normal',
        'high'
    );

    add_meta_box(
        'meals_date',
        'Date',
        'meals_date',
        'meals',
        'normal',
        'high'
    );

    add_meta_box(
        'meals_cabin',
        'Cabin',
        'meals_cabin',
        'meals',
        'normal',
        'high'
    );
    add_meta_box(
        'meals_aircraft',
        'Aircraft',
        'meals_aircraft',
        'meals',
        'normal',
        'high'
    );
    add_meta_box(
        'select_meal_type',
        'Meal',
        'select_meal_type',
        'meals',
        'normal',
        'high'
    );
    add_meta_box(
        'meals_comments',
        'Comments',
        'meals_comments',
        'meals',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'add_meals_metaboxes');

function meals_route()
{
    global $post;
    // Get the route data if it's already been entered
    $route = get_post_meta($post->ID, 'route', true);
    // Output the field
    echo '<input type="text" name="route" value="' . $route  . '" class="widefat">';
}

function meals_date()
{
    global $post;
    // Get the route data if it's already been entered
    $meal_date = get_post_meta($post->ID, 'meal_date', true);
    // Output the field
    echo '<input type="date" name="meal_date" value="' . $meal_date . '" class="widefat">';
}

function meals_cabin()
{
    global $post;
    // Get the route data if it's already been entered
    $cabin = get_post_meta($post->ID, 'cabin', true);
    // Output the field
    echo '<input type="text" name="cabin" value="' . $cabin . '" class="widefat">';
}

function meals_aircraft()
{
    global $post;
    // Get the route data if it's already been entered
    $cabin = get_post_meta($post->ID, 'aircraft', true);
    // Output the field
    echo '<input type="text" name="aircraft" value="' . $cabin . '" class="widefat">';
}

function select_meal_type()
{
    global $post;

    $meal = get_post_meta($post->ID, 'meal', true);
    echo '<select name="meal" id="meal" class="widefat">
    <option value="breakfast" ' . (($meal == 'breakfast') ? 'selected="selected"' : "") . '>Breakfast</option>
    <option value="lunch" ' . (($meal == 'lunch') ? 'selected="selected"' : "") . '>Lunch </option>
    <option value="dinner" ' . (($meal == 'dinner') ? 'selected="selected"' : "") . '> Dinner  </option>
  </select>';
}


function meals_comments()
{
    global $post;
    // Get the route data if it's already been entered
    $comments = get_post_meta($post->ID, 'comments', true);
    // Output the field
    echo '<textarea  type="textara" rows="3" name="comments" class="widefat" >' . $comments . '</textarea>';
}




/**
 * Save the metabox data
 */
function save_meals_meta($post_id, $post)
{

    // Return if the user doesn't have edit permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // This sanitizes the data from the field and saves it into an array $meals_meta.
    $meals_meta['route'] = esc_textarea($_POST['route']);
    $meals_meta['meal_date'] = esc_textarea($_POST['meal_date']);
    $meals_meta['cabin'] = esc_textarea($_POST['cabin']);
    $meals_meta['aircraft'] = esc_textarea($_POST['aircraft']);
    $meals_meta['meal'] = esc_textarea($_POST['meal']);
    $meals_meta['comments'] = esc_textarea($_POST['comments']);

    foreach ($meals_meta as $key => $value) :

        if (get_post_meta($post_id, $key, false)) {
            // If the custom field already has a value, update it.
            update_post_meta($post_id, $key, $value);
        } else {
            // If the custom field doesn't have a value, add it.
            add_post_meta($post_id, $key, $value);
        }

        if (!$value) {
            // Delete the meta key if there's no value
            delete_post_meta($post_id, $key);
        }

    endforeach;
}
add_action('save_post', 'save_meals_meta', 1, 2);


// Meals Gallery 

// Add Meta Box to post
add_action('add_meta_boxes', 'multi_media_uploader_meta_box');

function multi_media_uploader_meta_box()
{
    add_meta_box('meal-media-box', 'Meal Media', 'multi_media_uploader_meta_box_func', 'meals', 'normal', 'high');
}

function multi_media_uploader_meta_box_func($post)
{
    $banner_img = get_post_meta($post->ID, 'post_banner_img', true);
    ?>
    <style type="text/css">
        .multi-upload-medias ul li .delete-img {
            position: absolute;
            right: 3px;
            top: 2px;
            background: aliceblue;
            border-radius: 50%;
            cursor: pointer;
            font-size: 14px;
            line-height: 20px;
            color: red;
        }

        .multi-upload-medias ul li {
            width: 120px;
            display: inline-block;
            vertical-align: middle;
            margin: 5px;
            position: relative;
        }

        .multi-upload-medias ul li img {
            width: 100%;
        }
    </style>

    <table cellspacing="10" cellpadding="10">
        <tr>
            <td>Add Images</td>
            <td>
                <?php echo multi_media_uploader_field('post_banner_img', $banner_img); ?>
            </td>
        </tr>
    </table>

<?php
}


function multi_media_uploader_field($name, $value = '')
{
    $image = '">Add Media';
    $image_str = '';
    $image_size = 'full';
    $display = 'none';
    $value = explode(',', $value);

    if (!empty($value)) {
        foreach ($value as $values) {
            if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
                $image_str .= '<li data-attechment-id=' . $values . '><a href="' . $image_attributes[0] . '" target="_blank"><img src="' . $image_attributes[0] . '" /></a><i class="dashicons dashicons-no delete-img"></i></li>';
            }
        }
    }

    if ($image_str) {
        $display = 'inline-block';
    }

    return '<div class="multi-upload-medias"><ul>' . $image_str . '</ul><a href="#" class="wc_multi_upload_image_button button' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" /><a href="#" class="wc_multi_remove_image_button button" style="display:inline-block;display:' . $display . '">Remove media</a></div>';
}

// Save Meta Box values.
add_action('save_post', 'wc_meta_box_save');

function wc_meta_box_save($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post')) {
        return;
    }

    if (isset($_POST['post_banner_img'])) {
        update_post_meta($post_id, 'post_banner_img', $_POST['post_banner_img']);
    }
}
