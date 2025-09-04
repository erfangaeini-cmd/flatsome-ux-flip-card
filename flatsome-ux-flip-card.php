<?php
/**
 * Plugin Name: Flatsome UX Flip Card
 * Description: Adds a Flip Card element to Flatsome UX Builder (front/back images, hover/click, X/Y, aspect ratio or fixed height, overlay/CTA).
 * Version: 1.0.0
 * Author: Your Team
 * License: GPL-2.0-or-later
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined('ABSPATH') ) exit;

class UXB_Flip_Card_V1 {
  const SLUG = 'ux_flip_card';

  public function __construct(){
    add_shortcode(self::SLUG, [$this, 'render']);
    add_action('wp_enqueue_scripts', [$this, 'assets']);
    add_action('init', [$this, 'register_ux_builder']);
  }

  public function assets(){
    $css =
      '.uxb-flip{position:relative;display:block;width:100%;perspective:1200px;--radius:16px;--dur:.6s;--ease:cubic-bezier(.2,.6,.2,1);--shadow:0 10px 30px rgba(0,0,0,.12);--ratio:66.666%;--h:360px}' .
      '.uxb-flip__inner{position:relative;width:100%;height:0;padding-top:var(--ratio);transform-style:preserve-3d;transition:transform var(--dur) var(--ease);border-radius:var(--radius);box-shadow:var(--shadow)}' .
      '.uxb-flip[data-height=fixed] .uxb-flip__inner{height:var(--h);padding-top:0}' .
      '.uxb-flip[data-trigger=hover]:hover .uxb-flip__inner{transform:rotateY(180deg)}' .
      '.uxb-flip.is-flipped .uxb-flip__inner{transform:rotateY(180deg)}' .
      '.uxb-flip[data-direction=x]:hover .uxb-flip__inner,.uxb-flip[data-direction=x].is-flipped .uxb-flip__inner{transform:rotateX(180deg)}' .
      '.uxb-face{position:absolute;inset:0;border-radius:var(--radius);overflow:hidden;backface-visibility:hidden;-webkit-backface-visibility:hidden}' .
      '.uxb-front{transform:rotateY(0)}.uxb-back{transform:rotateY(180deg)}.uxb-flip[data-direction=x] .uxb-back{transform:rotateX(180deg)}' .
      '.uxb-media{width:100%;height:100%;object-fit:cover;object-position:50% 50%;display:block}' .
      '.uxb-overlay{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;padding:18px;text-align:center}' .
      '.uxb-overlay--dark{background:linear-gradient(0deg,rgba(0,0,0,.45),rgba(0,0,0,.45));color:#fff}' .
      '.uxb-overlay--light{background:linear-gradient(0deg,rgba(255,255,255,.5),rgba(255,255,255,.5));color:#111}' .
      '.uxb-title{font-size:1.15rem;font-weight:700;line-height:1.3;margin:0}' .
      '.uxb-cta{margin-top:.75rem;display:inline-flex;gap:.4rem;padding:.55rem .9rem;border-radius:999px;background:#111;color:#fff;font-size:.9rem;text-decoration:none}';

    wp_register_style('uxb-flip-card', false);
    wp_enqueue_style('uxb-flip-card');
    wp_add_inline_style('uxb-flip-card', $css);

    $js = "(function(){var d=document;d.addEventListener('click',function(e){var c=e.target.closest('.uxb-flip[data-trigger=click]');if(c && !e.target.closest('a,button,input,select,textarea')){c.classList.toggle('is-flipped');}},{passive:true});})();";
    wp_register_script('uxb-flip-card', '');
    wp_enqueue_script('uxb-flip-card');
    wp_add_inline_script('uxb-flip-card', $js);
  }

  private function with_unit($val, $unit='px'){
    $s = trim((string)$val);
    if($s === '') return '0'.$unit;
    if(preg_match('/[a-z%]+$/i', $s)) return $s;
    if(is_numeric($s)) return $s.$unit;
    return $s;
  }

  private function image($id_or_url, $alt=''){
    if(!$id_or_url) return '';
    if(is_numeric($id_or_url)){
      return wp_get_attachment_image(intval($id_or_url), 'large', false, [
        'class' => 'uxb-media', 'alt' => esc_attr($alt), 'loading'=>'lazy', 'decoding'=>'async'
      ]);
    }
    return '<img class="uxb-media" src="'.esc_url($id_or_url).'" alt="'.esc_attr($alt).'" loading="lazy" decoding="async" />';
  }

  public function render($atts){
    $a = shortcode_atts([
      'trigger'       => 'hover',     // hover|click
      'direction'     => 'y',         // y|x
      'height_mode'   => 'ratio',     // ratio|fixed
      'ratio'         => '66.666%',
      'height_px'     => '360',
      'radius'        => '16',        // number or unit string
      // media
      'front_image'   => '',
      'back_image'    => '',
      'front_title'   => '',
      'back_title'    => '',
      'front_overlay' => 'dark',      // none|dark|light
      'back_overlay'  => 'dark',
      // CTA (optional, one link both sides)
      'cta_text'      => '',
      'cta_url'       => '',
      'class'         => '',
    ], $atts, self::SLUG);

    $dir = ($a['direction']==='x') ? 'x' : 'y';
    $ov1 = ($a['front_overlay']==='light') ? 'uxb-overlay--light' : (($a['front_overlay']==='none') ? '' : 'uxb-overlay--dark');
    $ov2 = ($a['back_overlay']==='light')  ? 'uxb-overlay--light'  : (($a['back_overlay']==='none')  ? '' : 'uxb-overlay--dark');

    $height_data = ($a['height_mode']==='fixed') ? 'fixed' : 'ratio';
    $radius_css  = $this->with_unit($a['radius'], 'px');

    ob_start(); ?>
    <div class="uxb-flip <?php echo esc_attr($a['class']); ?>"
         data-trigger="<?php echo esc_attr($a['trigger']); ?>"
         data-direction="<?php echo esc_attr($dir); ?>"
         data-height="<?php echo esc_attr($height_data); ?>"
         role="group" aria-label="Flip card">
      <div class="uxb-flip__inner"
           style="--ratio:<?php echo esc_attr($a['ratio']); ?>; --h:<?php echo intval($a['height_px']); ?>px; --radius:<?php echo esc_attr($radius_css); ?>;">
        <div class="uxb-face uxb-front">
          <?php echo $this->image($a['front_image'], $a['front_title']); ?>
          <?php if($a['front_title'] || $a['cta_text']): ?>
            <div class="uxb-overlay <?php echo esc_attr($ov1); ?>">
              <div>
                <?php if($a['front_title']): ?><h3 class="uxb-title"><?php echo esc_html($a['front_title']); ?></h3><?php endif; ?>
                <?php if($a['cta_text'] && $a['cta_url']): ?><a class="uxb-cta" href="<?php echo esc_url($a['cta_url']); ?>"><?php echo esc_html($a['cta_text']); ?></a><?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
        <div class="uxb-face uxb-back">
          <?php echo $this->image($a['back_image'], $a['back_title']); ?>
          <?php if($a['back_title'] || $a['cta_text']): ?>
            <div class="uxb-overlay <?php echo esc_attr($ov2); ?>">
              <div>
                <?php if($a['back_title']): ?><h3 class="uxb-title"><?php echo esc_html($a['back_title']); ?></h3><?php endif; ?>
                <?php if($a['cta_text'] && $a['cta_url']): ?><a class="uxb-cta" href="<?php echo esc_url($a['cta_url']); ?>"><?php echo esc_html($a['cta_text']); ?></a><?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php return ob_get_clean();
  }

  public function register_ux_builder(){
    if( ! function_exists('add_ux_builder_shortcode') ) return;

    add_ux_builder_shortcode( self::SLUG, [
      'name'     => __('Flip Card','ux-builder'),
      'category' => __('Content','ux-builder'),
      'options'  => [
        'trigger' => [ 'type'=>'select', 'heading'=>__('Trigger','ux-builder'), 'default'=>'hover', 'options'=>['hover'=>'Hover','click'=>'Click/Tap'] ],
        'direction' => [ 'type'=>'select', 'heading'=>__('Direction','ux-builder'), 'default'=>'y', 'options'=>['y'=>'Horizontal (Y)','x'=>'Vertical (X)'] ],
        'height_mode' => [ 'type'=>'select', 'heading'=>__('Height Mode','ux-builder'), 'default'=>'ratio', 'options'=>['ratio'=>'Aspect Ratio','fixed'=>'Fixed Height'] ],
        'ratio' => [ 'type'=>'textfield', 'heading'=>__('Aspect Ratio %','ux-builder'), 'default'=>'66.666%', 'conditions'=>'height_mode == "ratio"' ],
        'height_px' => [ 'type'=>'textfield', 'heading'=>__('Fixed Height (px)','ux-builder'), 'default'=>'360', 'conditions'=>'height_mode == "fixed"' ],
        'radius' => [ 'type'=>'textfield', 'heading'=>__('Border Radius (px, unit optional)','ux-builder'), 'default'=>'16' ],

        'front_image' => [ 'type'=>'image', 'heading'=>__('Front Image','ux-builder') ],
        'front_title' => [ 'type'=>'textfield', 'heading'=>__('Front Title','ux-builder') ],
        'front_overlay' => [ 'type'=>'select', 'heading'=>__('Front Overlay','ux-builder'), 'default'=>'dark', 'options'=>['none'=>'None','dark'=>'Dark','light'=>'Light'] ],

        'back_image' => [ 'type'=>'image', 'heading'=>__('Back Image','ux-builder') ],
        'back_title' => [ 'type'=>'textfield', 'heading'=>__('Back Title','ux-builder') ],
        'back_overlay' => [ 'type'=>'select', 'heading'=>__('Back Overlay','ux-builder'), 'default'=>'dark', 'options'=>['none'=>'None','dark'=>'Dark','light'=>'Light'] ],

        'cta_text' => [ 'type'=>'textfield', 'heading'=>__('CTA Text','ux-builder') ],
        'cta_url'  => [ 'type'=>'textfield', 'heading'=>__('CTA URL','ux-builder') ],

        'class'    => [ 'type'=>'textfield', 'heading'=>__('Extra class','ux-builder') ],
      ]
    ]);
  }
}
new UXB_Flip_Card_V1();
