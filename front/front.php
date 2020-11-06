<?php

if (!defined('ABSPATH'))
  exit;

if (!class_exists('IBFW_front')) {

    class IBFW_front {

        protected static $instance;
       
        function IBFW_frontdesign() {
            global $product;
            $is_setup = false;
            $price = $product->get_price();
            $categories = $product->get_category_ids();
            $tags = $product->get_tag_ids();
            $args = array(
                'post_type' => 'product_label',
            );
            $query = new WP_Query( $args );
            if( $query->have_posts() ) {
                while( $query->have_posts() ) { 
                    $query->the_post();
                    global $post; 
                    
                    $pro_con = get_post_meta($post->ID,'ocpl_pro_condition',true);
                    if($is_setup!=true){
                        if($pro_con == "price") {
                            $price_con = get_post_meta($post->ID,'ocpl_price_condition',true);
                            if($price_con == "between") {
                                $ocpl_bet1 = get_post_meta($post->ID,'ocpl_bet1',true);
                                $ocpl_bet2 = get_post_meta($post->ID,'ocpl_bet2',true);
                                if($price > $ocpl_bet1 && $price < $ocpl_bet2) {
                                    $this->IBFW_create_label($post->ID);
                                    $is_setup = true;
                                }
                            }
                            if($price_con == "lessthan") {
                                $ocpl_price = get_post_meta($post->ID,'ocpl_price',true);
                                if($price < $ocpl_price) {
                                    $this->IBFW_create_label($post->ID);
                                    $is_setup = true;
                                }
                            }
                            if($price_con == "greaterthan") {
                                $ocpl_price = get_post_meta($post->ID,'ocpl_price',true);
                                if($price > $ocpl_price) {
                                    $this->IBFW_create_label($post->ID);
                                    $is_setup = true;
                                }
                            }
                        }elseif($pro_con == "category") {
                            $category = get_post_meta($post->ID,'ocpl_cat',true);
                            if(array_intersect($category, $categories)){
                                $this->IBFW_create_label($post->ID);
                                $is_setup = true;
                            }
                        }elseif($pro_con == "tag") {
                            $tag = get_post_meta($post->ID,'ocpl_tag',true);
                            if(array_intersect($tags, $tag)){
                                $this->IBFW_create_label($post->ID);
                                $is_setup = true;
                            }
                        }elseif($pro_con == "onsale") {
                            $on_sale = get_post_meta($post->ID,'ocpl_onsale',true);
                            if( $on_sale == "no") {
                                if(empty($product->is_on_sale())){
                                    $this->IBFW_create_label($post->ID);
                                    $is_setup = true;
                                }
                            }else {
                                if($product->is_on_sale() == 1){
                                    $this->IBFW_create_label($post->ID);
                                    $is_setup = true;
                                }
                            }                       
                        }else{
                            $this->IBFW_create_label($post->ID);
                            $is_setup = true;
                        }
                    }
                }
            }
            wp_reset_postdata();
        }

        function IBFW_create_label($post_id){
            $lbl = get_post_meta($post_id,'ocpl_show_label',true);

            $left = get_post_meta($post_id,'ocpl_left',true); 
            $right = get_post_meta($post_id,'ocpl_right',true); 
            $top = get_post_meta($post_id,'ocpl_top',true); 
            $bottom = get_post_meta($post_id,'ocpl_bottom',true);

            $discount = get_post_meta($post_id,'ocpl_discount',true);
            $ocpl_dis_sign = get_post_meta($post_id,'ocpl_dis_sign',true);
            $ocpl_discount_text = get_post_meta($post_id,'ocpl_discount_text',true);
            $text_postion = get_post_meta($post_id,'ocpl_discount_text_postion',true);

            $color = get_post_meta($post_id,'ocpl_font_clr',true);
            $bgcolor = get_post_meta($post_id,'ocpl_bg_clr',true);
            $ft_size = get_post_meta($post_id,'ocpl_ft_size',true);
            
            $shape = get_post_meta($post_id, 'ocpl_lbl_shape', true);

            if($text_postion == "top") {
                $text = '<span class="top" style="font-size: '.$ft_size.'px;">'.$ocpl_discount_text.'</span>'; 
                $text .= '<span class="bottom"  style="font-size: '.$ft_size.'px;">'.$discount.$ocpl_dis_sign.'</span>';
            }
            if($text_postion == "bottom") {
                $text = '<span class="top" style="font-size: '.$ft_size.'px;">'.$discount.$ocpl_dis_sign.'</span>'; 
                $text .= '<span class="bottom" style="font-size: '.$ft_size.'px;">'.$ocpl_discount_text.'</span>'; 
            }
           
            if($right != 0){
                $left = "inherit";
            }else{
                $left = $left."px";
            }


            $style = "top:".$top."px;right:".$right."px;bottom:".$bottom."px;left:".$left.";background-color:".$bgcolor.";color:".$color.";";


            if($lbl == "on") {
                if($shape == "square"){
                    ?>
                        <div class="square_data">
                            <div class="square" style="<?php echo $style; ?>">
                                <b><?php echo $text; ?></b>
                            </div>
                        </div>
                    <?php
                }else if($shape == "rectangle"){
                    ?>
                        <div class="square_data">
                            <div class="rectangle" style="<?php echo $style; ?>">
                                <b><?php echo $text; ?></b>
                            </div>
                        </div>
                    <?php
                }else if($shape == "rectangle_up"){
                    ?>
                        <div class="square_data">
                            <div class="rectangle_up" style="<?php echo $style; ?>">
                                <b><?php echo $text; ?></b>
                            </div>
                        </div>
                    <?php
                }else if($shape == "offers"){
                    ?>
                        <div class="square_data">
                            <div class="offers" style="<?php echo $style; ?>">
                                <i style="background-color:<?php echo $bgcolor?>; border-color:<?php echo $bgcolor?>;" class="template-i "></i>            
                                <i style="background-color:<?php echo $bgcolor?>; border-color:<?php echo $bgcolor?>;" class="template-i-before "></i>
                                <b><?php echo $text; ?></b>
                            </div>
                        </div>
                    <?php
                }else if($shape == "tag"){
                    ?>
                        <div class="square_data">
                            <div class="tag" style="<?php echo $style; ?>">
                                <i style="background-color:<?php echo $bgcolor?>; border-color:<?php echo $bgcolor?>;" class="template-span-before "></i>
                                <b><?php echo $text; ?></b>
                            </div>
                        </div>
                    <?php
                }else if($shape == "collar"){
                    ?>
                        <div class="square_data">
                            <div class="collar" style="<?php echo $style; ?>">
                                <i style="border-color:<?php echo $bgcolor?>;" class="template-span-before "></i>
                                <i style="border-color:<?php echo $bgcolor?>;" class="template-i-after "></i>
                                <b><?php echo $text; ?></b>
                            </div>
                        </div>
                    <?php
                }else if($shape == "rectangle_round"){
                    ?>
                        <div class="square_data">
                            <div class="rectangle_round" style="<?php echo $style; ?>">
                                <b><?php echo $text; ?></b>
                            </div>
                        </div>
                    <?php
                }else if($shape == "rectangle_circle"){
                    ?>
                        <div class="square_data">
                            <div class="rectangle_circle" style="<?php echo $style; ?>">
                                <b><?php echo $text; ?></b>
                            </div>
                        </div>
                    <?php
                }else if($shape == "circle"){
                    ?>
                        <div class="square_data">
                            <div class="circle" style="<?php echo $style; ?>">
                                <b><?php echo $text; ?></b>
                            </div>
                        </div>
                    <?php
                }else if($shape == "corner_badge"){
                    ?>
                        <div class="square_data">
                            <div class="corner_badge" style="color: <?php echo $color; ?>;"> 
                                <i style="background-color:<?php echo $bgcolor?>; border-color:<?php echo $bgcolor?>;" class="template-i-before "></i>
                                <i class="template-i-after "><b><?php echo $text; ?></b></i>
                                
                            </div>
                        </div>
                    <?php
                }
            }
        }



        function init() {
            add_action( 'woocommerce_before_shop_loop_item_title', array($this, 'IBFW_frontdesign'), 1, 0 ); 
        }

        public static function instance() {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->init();
            }
            return self::$instance;
        }
    }
    IBFW_front::instance();
}

