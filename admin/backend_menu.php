<?php

if (!defined('ABSPATH'))
  exit;

if (!class_exists('IBFW_back')) {

    class IBFW_back {

        protected static $instance;
       
        function IBFW_create_custpost() {
            $post_type = 'product_label';
            $singular_name = 'Product Label';
            $plural_name = 'Product Labels';
            $slug = 'product_label';
            $labels = array(
                'name'               => _x( $plural_name, 'post type general name', 'ocpl' ),
                'singular_name'      => _x( $singular_name, 'post type singular name', 'ocpl' ),
                'menu_name'          => _x( $singular_name, 'admin menu name', 'ocpl' ),
                'name_admin_bar'     => _x( $singular_name, 'add new name on admin bar', 'ocpl' ),
                'add_new'            => __( 'Add New', 'ocpl' ),
                'add_new_item'       => __( 'Add New '.$singular_name, 'ocpl' ),
                'new_item'           => __( 'New '.$singular_name, 'ocpl' ),
                'edit_item'          => __( 'Edit '.$singular_name, 'ocpl' ),
                'view_item'          => __( 'View '.$singular_name, 'ocpl' ),
                'all_items'          => __( 'All '.$plural_name, 'ocpl' ),
                'search_items'       => __( 'Search '.$plural_name, 'ocpl' ),
                'parent_item_colon'  => __( 'Parent '.$plural_name.':', 'ocpl' ),
                'not_found'          => __( 'No Table found.', 'ocpl' ),
                'not_found_in_trash' => __( 'No Table found in Trash.', 'ocpl' )
            );

            $args = array(
                'labels'             => $labels,
                'description'        => __( 'Description.', 'ocpl' ),
                'public'             => false,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => $slug ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'supports'           => array( 'title' ),
                'menu_icon'          => 'dashicons-awards'
            );
            register_post_type( $post_type, $args );
        }

        function IBFW_add_meta_box() {
            add_meta_box(
                'OCPL_metabox',
                __( 'Label Settings', 'ocpl' ),
                array($this, 'IBFW_metabox_cb'),
                'product_label',
                'normal'
            );
        }

        function IBFW_metabox_cb( $post ) {
            // Add a nonce field so we can check for it later.
            wp_nonce_field( 'OCPL_meta_save', 'OCPL_meta_save_nounce' );
            ?> 
            <div class="ocpl_container">
                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-default">
                        <?php echo __( 'Default Settings', IBFW_DOMAIN );?>
                    </li>
                    <li class="tab-link" data-tab="tab-data">
                        <?php echo __( 'Label Design', IBFW_DOMAIN );?>
                    </li>
                    <li class="tab-link" data-tab="tab-general">
                        <?php echo __( 'Product Settings', IBFW_DOMAIN );?>
                    </li>
                    
                </ul>
                <div id="tab-default" class="tab-content current">
                    <div class="attribute_div">
                        <div class="label_div">Show Label</div>
                        <div class="input_div">
                            <?php $lbl = get_post_meta($post->ID,'ocpl_show_label',true); ?>
                            <input type="checkbox" name="ocpl_show_label" <?php if($lbl == "on"){ echo "checked"; } ?>> 
                        </div>
                    </div>  
                    <div class="attribute_div">
                        <div class="label_div">Position</div>
                        <div class="input_div">
                            <?php 
                                $left = get_post_meta($post->ID,'ocpl_left',true); 
                                $right = get_post_meta($post->ID,'ocpl_right',true); 
                                $top = get_post_meta($post->ID,'ocpl_top',true); 
                                $bottom = get_post_meta($post->ID,'ocpl_bottom',true); 
                                if(empty($left)){
                                    $left = "-20";
                                }else{
                                    $left = $left;
                                }

                                if(empty($right)){
                                    $right = "0";
                                }else{
                                    $right = $right;
                                }

                                if(empty($top)){
                                    $top = "-20";
                                }else{
                                    $top = $top;
                                }

                                if(empty($bottom)){
                                    $bottom = "0";
                                }else{
                                    $bottom = $bottom;
                                }
                            ?>
                            <label>Left</label></br>
                            <input type="number" name="ocpl_left" value="<?php echo $left; ?>"></br>
                            <label>Right</label></br>
                            <input type="number" name="ocpl_right" value="<?php echo $right; ?>"></br>
                            <label>Top</label></br>
                            <input type="number" name="ocpl_top" value="<?php echo $top; ?>"></br>
                            <label>Bottom</label></br>
                            <input type="number" name="ocpl_bottom" value="<?php echo $bottom; ?>"></br>
                        </div>
                    </div> 
                    <div class="attribute_div">
                        <div class="label_div">Discount</div>
                        <div class="input_div">
                            <?php 
                                $discount = get_post_meta($post->ID,'ocpl_discount',true);
                                if(empty($discount)){
                                    $discount = "20";
                                }else{
                                    $discount = $discount;
                                }
                            ?>
                            <input type="text" name="ocpl_discount" value="<?php echo $discount; ?>"> 
                        </div>
                    </div> 
                    <div class="attribute_div">
                        <div class="label_div">Discount Sign</div>
                        <div class="input_div">
                            <?php $ocpl_dis_sign = get_post_meta($post->ID,'ocpl_dis_sign',true); ?>
                            <select name="ocpl_dis_sign">
                                <option value="%" <?php if($ocpl_dis_sign == "%") { echo "selected"; } ?>>%</option>
                                <option value="-" <?php if($ocpl_dis_sign == "-") { echo "selected"; } ?>>-</option>
                            </select> 
                        </div>
                    </div> 
                    <div class="attribute_div">
                        <div class="label_div">Discount Text</div>
                        <div class="input_div">
                            <?php 
                                $ocpl_discount_text = get_post_meta($post->ID,'ocpl_discount_text',true);
                                if(empty($ocpl_discount_text)){
                                    $ocpl_discount_text = "OFF";
                                }else{
                                    $ocpl_discount_text = $ocpl_discount_text;
                                }
                            ?>
                            <input type="text" name="ocpl_discount_text" value="<?php echo $ocpl_discount_text; ?>">
                        </div>
                    </div>  
                    <div class="attribute_div">
                        <div class="label_div">Discount Text Position</div>
                        <div class="input_div">
                            <?php $text_postion = get_post_meta($post->ID,'ocpl_discount_text_postion',true); ?>
                           <select name="ocpl_discount_text_postion">
                               <option value="top" <?php if($text_postion == "top") { echo "selected"; } ?>>Top Of Discount</option>
                               <option value="bottom" <?php if($text_postion == "bottom") { echo "selected"; } ?>>Bottom Of Discount</option>
                           </select>
                        </div>
                    </div>                  
                </div>
                <div id="tab-data" class="tab-content">
                    <div class="attribute_div">
                        <div class="label_div">Label Font Color</div>
                        <div class="input_div">
                            <?php 
                                $color = get_post_meta($post->ID,'ocpl_font_clr',true); 
                                if(empty($color)) {
                                    $color = "#ffffff";
                                }
                            ?>
                            <input type="color" name="ocpl_font_clr" value="<?php echo $color; ?>"> 
                        </div>
                    </div>
                    <div class="attribute_div">
                        <div class="label_div">Background Color</div>
                        <div class="input_div">
                            <?php $bgcolor = get_post_meta($post->ID,'ocpl_bg_clr',true); ?>
                            <input type="color" name="ocpl_bg_clr" value="<?php echo $bgcolor; ?>"> 
                        </div>
                    </div>
                    <div class="attribute_div">
                        <div class="label_div">Font Size</div>
                        <div class="input_div">
                            <?php 
                                $ocpl_ft_size = get_post_meta($post->ID,'ocpl_ft_size',true); 
                                if(empty($ocpl_ft_size)){
                                    $ft_size = "12";
                                }else{
                                    $ft_size = $ocpl_ft_size;
                                }
                            ?>
                            <input type="number" name="ocpl_ft_size" value="<?php echo $ft_size; ?>"> 
                        </div>
                    </div>
                    <div class="attribute_div">
                        <div class="label_div">Label Shape</div>
                        <div class="input_div">
                            <?php $shape = get_post_meta($post->ID, 'ocpl_lbl_shape', true); ?>
                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="square" <?php if($shape == "square" || empty($shape)){ echo "checked"; }?> />
                                <div class="square_data">
                                    <div class="square"></div>
                                </div>
                            </label>

                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="rectangle" <?php if($shape == "rectangle"){ echo "checked"; }?>/>
                                <div class="square_data">
                                    <div class="rectangle"></div>
                                </div>
                            </label>

                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="rectangle_up" <?php if($shape == "rectangle_up"){ echo "checked"; }?>/>
                                <div class="square_data">
                                    <div class="rectangle_up"></div>
                                </div>
                            </label>
                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="offers" <?php if($shape == "offers"){ echo "checked"; }?>/>
                                <div class="square_data">
                                    <div class="offers">
                                        <i style="background-color:#dac6c8; border-color:#dac6c8;" class="template-i "></i>            
                                        <i style="background-color:#dac6c8; border-color:#dac6c8;" class="template-i-before "></i>
                                    </div>
                                </div>
                            </label>

                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="tag" <?php if($shape == "tag"){ echo "checked"; }?>/>
                                <div class="square_data">
                                    <div class="tag">
                                        <i style="background-color:#8aaae5; border-color:#8aaae5;" class="template-span-before "></i>
                                    </div>
                                </div>
                            </label>

                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="collar" <?php if($shape == "collar"){ echo "checked"; }?>/>
                                <div class="square_data">
                                    <div class="collar">
                                        <i style="background-color:#295f2d; border-color:#295f2d;" class="template-span-before "></i>
                                        <i style="background-color:#295f2d; border-color:#295f2d;" class="template-i-after "></i>
                                    </div>
                                </div>
                            </label>

                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="rectangle_round" <?php if($shape == "rectangle_round"){ echo "checked"; }?>/>
                                <div class="square_data">
                                    <div class="rectangle_round">
                                    </div>
                                </div>
                            </label>

                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="rectangle_circle" <?php if($shape == "rectangle_circle"){ echo "checked"; }?>/>
                                <div class="square_data">
                                    <div class="rectangle_circle">
                                    </div>
                                </div>
                            </label>

                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="circle" <?php if($shape == "circle"){ echo "checked"; }?>/>
                                <div class="square_data">
                                    <div class="circle">
                                    </div>
                                </div>
                            </label>

                            <label class="layersMenu">
                                <input type="radio" name="ocpl_lbl_shape" value="corner_badge" <?php if($shape == "corner_badge"){ echo "checked"; }?>/>
                                <div class="square_data">
                                    <div class="corner_badge">
                                        <i style="background-color:#adf0d1; border-color:#adf0d1;" class="template-i-before "></i>
                                        <i class="template-i-after "></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="tab-general" class="tab-content">
                    <div class="attribute_div">
                        <div class="label_div">Condition</div>
                        <div class="input_div">
                            <?php $pro_con = get_post_meta($post->ID,'ocpl_pro_condition',true); ?>
                            <select class="ocpl_pro_condition" name="ocpl_pro_condition">
                                <option value="">Select Option</option>
                                <option value="price" <?php if($pro_con == "price") { echo "selected"; } ?>>Price</option>
                                <option value="category" <?php if($pro_con == "category") { echo "selected"; } ?>>Category</option>
                                <option value="tag" <?php if($pro_con == "tag") { echo "selected"; } ?>>Tag</option>
                                <option value="onsale" <?php if($pro_con == "onsale") { echo "selected"; } ?>>On Sale</option>
                            </select>
                        </div>
                    </div>   
                    <div class="attribute_div">
                        <div class="child_div ocpl_price_div" style="display: none;">
                            <h2 class="des_head">Price</h2>
                            <label>Price</label>
                            <?php $price_con = get_post_meta($post->ID,'ocpl_price_condition',true); ?>
                            <select class="ocpl_price_condition" name="ocpl_price_condition">
                                <option value="between" <?php if($price_con == "between") { echo "selected"; } ?>>Between</option>
                                <option value="lessthan" <?php if($price_con == "lessthan") { echo "selected"; } ?>>Less than</option>
                                <option value="greaterthan" <?php if($price_con == "greaterthan") { echo "selected"; } ?>>Greater than</option>
                            </select>
                            <div class="ocpl_price_between_div">
                                <?php $ocpl_bet1 = get_post_meta($post->ID,'ocpl_bet1',true); ?>
                                <label>Price 1</label>
                                <input type="number" name="ocpl_bet1" value="<?php echo $ocpl_bet1; ?>">
                                <?php $ocpl_bet2 = get_post_meta($post->ID,'ocpl_bet2',true); ?>
                                <label>Price 2</label>
                                <input type="number" name="ocpl_bet2" value="<?php echo $ocpl_bet2; ?>">
                            </div>
                            <div class="ocpl_price_single_div" style="display: none;">
                                <?php $ocpl_price = get_post_meta($post->ID,'ocpl_price',true); ?>
                                <label>Price</label>
                                <input type="number" name="ocpl_price" value="<?php echo $ocpl_price; ?>">
                            </div>
                        </div>
                        <div class="child_div ocpl_category_div" style="display: none;">
                            <h2 class="des_head">Category</h2>
                            <?php
                                $orderby = 'name';
                                $order = 'asc';
                                $hide_empty = false;
                                $cat_args = array(
                                    'orderby'    => $orderby,
                                    'order'      => $order,
                                    'hide_empty' => $hide_empty,
                                    'parent' => 0,
                                );
                                $ocpl_categories = get_terms( 'product_cat', $cat_args );
                                //print_r($ocpl_categories);
                                $category = get_post_meta($post->ID,'ocpl_cat',true);
                                foreach( $ocpl_categories as $ocpl_category ) {
                                    ?>
                                    <input type="checkbox" name="ocpl_cat[]" value="<?php echo $ocpl_category->term_id;?>" <?php if(!empty($category) && in_array($ocpl_category->term_id,$category)){echo "checked";} ?>><?php echo $ocpl_category->name;?></br>
                                    <?php 
                                } 
                            ?>   
                        </div>
                        <div class="child_div ocpl_tag_div" style="display: none;">
                            <h2 class="des_head">Tag</h2>
                            <?php
                                $ocpl_tags = $terms = get_terms(array('taxonomy' => 'product_tag', 'hide_empty' => false));
                                $tag = get_post_meta($post->ID,'ocpl_tag',true);
                                foreach( $ocpl_tags as $ocpl_tag ) {
                                    ?>
                                        <input type="checkbox" name="ocpl_tag[]" value="<?php echo $ocpl_tag->term_id;?>" <?php if(!empty($tag) && in_array($ocpl_tag->term_id,$tag)){echo "checked";} ?>><?php echo $ocpl_tag->name;?></br>
                                    <?php 
                                } 
                            ?>
                        </div>
                        <div class="child_div ocpl_onsale_div" style="display: none;">
                            <h2 class="des_head">Onsale</h2>
                            <?php $on_sale = get_post_meta($post->ID,'ocpl_onsale',true); ?>
                            <label>Is on Sale</label>
                            <select name="ocpl_onsale" class="ocpl_onsale">
                                <option value="no" <?php if($on_sale == "no") { echo "selected"; } ?>>No</option>
                                <option value="yes" <?php if($on_sale == "yes") { echo "selected"; } ?>>Yes</option>
                            </select>
                        </div>
                    </div>          
                </div>
            </div>
            <?php
        }

        function IBFW_meta_save( $post_id, $post ){
            // the following line is needed because we will hook into edit_post hook, so that we can set default value of checkbox.
            if ($post->post_type != 'product_label') {return;}
            // Is the user allowed to edit the post or page?
            if ( !current_user_can( 'edit_post', $post_id )) return;
            // Perform checking for before saving
            $is_autosave = wp_is_post_autosave($post_id);
            $is_revision = wp_is_post_revision($post_id);
            $is_valid_nonce = (isset($_POST['OCPL_meta_save_nounce']) && wp_verify_nonce( $_POST['OCPL_meta_save_nounce'], 'OCPL_meta_save' )? 'true': 'false');

            if ( $is_autosave || $is_revision || !$is_valid_nonce ) return;

            /*=======================Label Setting================================*/
            $ocpl_show_label = sanitize_text_field( $_REQUEST['ocpl_show_label'] );
            update_post_meta($post_id, 'ocpl_show_label', $ocpl_show_label);

            $ocpl_left   = sanitize_text_field( $_REQUEST['ocpl_left'] ); 
            $ocpl_right  = sanitize_text_field( $_REQUEST['ocpl_right'] ); 
            $ocpl_top    = sanitize_text_field( $_REQUEST['ocpl_top'] );
            $ocpl_bottom = sanitize_text_field( $_REQUEST['ocpl_bottom'] );  
            update_post_meta($post_id, 'ocpl_left', $ocpl_left);
            update_post_meta($post_id, 'ocpl_right', $ocpl_right);
            update_post_meta($post_id, 'ocpl_top', $ocpl_top);
            update_post_meta($post_id, 'ocpl_bottom', $ocpl_bottom);

            $ocpl_discount = sanitize_text_field( $_REQUEST['ocpl_discount'] );
            update_post_meta($post_id, 'ocpl_discount', $ocpl_discount);

            $ocpl_dis_sign = sanitize_text_field( $_REQUEST['ocpl_dis_sign'] );
            update_post_meta($post_id, 'ocpl_dis_sign', $ocpl_dis_sign);

            $ocpl_discount_text = sanitize_text_field( $_REQUEST['ocpl_discount_text'] ); 
            update_post_meta($post_id, 'ocpl_discount_text', $ocpl_discount_text);

            $ocpl_discount_text_postion = sanitize_text_field( $_REQUEST['ocpl_discount_text_postion'] );
            update_post_meta($post_id,'ocpl_discount_text_postion',$ocpl_discount_text_postion);


            /*====================Design Setting==================================*/
            $ocpl_font_clr = sanitize_text_field( $_REQUEST['ocpl_font_clr'] );
            update_post_meta($post_id, 'ocpl_font_clr', $ocpl_font_clr);

            $ocpl_bg_clr = sanitize_text_field( $_REQUEST['ocpl_bg_clr'] );
            update_post_meta($post_id, 'ocpl_bg_clr', $ocpl_bg_clr);

            $ocpl_ft_size = sanitize_text_field( $_REQUEST['ocpl_ft_size'] );
            update_post_meta($post_id, 'ocpl_ft_size', $ocpl_ft_size);

            $ocpl_lbl_shape = sanitize_text_field( $_REQUEST['ocpl_lbl_shape'] );
            update_post_meta($post_id, 'ocpl_lbl_shape', $ocpl_lbl_shape);

            /*====================Design Setting==================================*/
            $ocpl_pro_condition = sanitize_text_field( $_REQUEST['ocpl_pro_condition'] );
            update_post_meta($post_id, 'ocpl_pro_condition', $ocpl_pro_condition);

                /*---price---*/
                $ocpl_price_condition = sanitize_text_field( $_REQUEST['ocpl_price_condition'] );
                update_post_meta($post_id, 'ocpl_price_condition', $ocpl_price_condition);

                $ocpl_bet1 = sanitize_text_field( $_REQUEST['ocpl_bet1'] );
                update_post_meta($post_id, 'ocpl_bet1', $ocpl_bet1);
                $ocpl_bet2 = sanitize_text_field( $_REQUEST['ocpl_bet2'] );
                update_post_meta($post_id, 'ocpl_bet2', $ocpl_bet2);
                $ocpl_price = sanitize_text_field( $_REQUEST['ocpl_price'] );
                update_post_meta($post_id, 'ocpl_price', $ocpl_price);
                /*---price---*/

                /*---category---*/
                $ocpl_cat = $this->recursive_sanitize_text_field( $_REQUEST['ocpl_cat'] );
                //$ocpl_cat = implode(",",$_REQUEST['ocpl_cat']);
                update_post_meta($post_id, 'ocpl_cat', $ocpl_cat);
                /*---category---*/

                /*---tag---*/
                $ocpl_tag = $this->recursive_sanitize_text_field( $_REQUEST['ocpl_tag'] );
                //$ocpl_tag = implode(",",$_REQUEST['ocpl_tag']);
                update_post_meta($post_id, 'ocpl_tag', $ocpl_tag);
                /*---tag---*/

                /*---onsale---*/
                $ocpl_onsale = sanitize_text_field( $_REQUEST['ocpl_onsale'] );
                update_post_meta($post_id, 'ocpl_onsale', $ocpl_onsale);
                /*---onsale---*/
        }
   
        function recursive_sanitize_text_field($array) {
            foreach ( $array as $key => &$value ) {
                if ( is_array( $value ) ) {
                    $value = $this->recursive_sanitize_text_field($value);
                }else{
                    $value = sanitize_text_field( $value );
                }
            }
            return $array;
        }


        function init() {
            add_action('init', array($this, 'IBFW_create_custpost'));
            add_action('add_meta_boxes', array($this, 'IBFW_add_meta_box'));
            add_action( 'edit_post', array($this, 'IBFW_meta_save'), 10, 2);
        }

        public static function instance() {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->init();
            }
            return self::$instance;
        }
    }
    IBFW_back::instance();
}

