<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
$doc = JFactory::getDocument();
$doc->setMetaData( 'ROBOTS', 'NOINDEX, NOFOLLOW' );

if(ipropertyHTML::isMobileRequest() && JPluginHelper::isEnabled('system', 'ipmobile')){
    ?>
    <script type="text/javascript">
        (function(window, PhotoSwipe){

            document.addEventListener('DOMContentLoaded', function(){
                var
                    options = {
                        preventHide: true,
                        getImageSource: function(obj){
                            return obj.url;
                        },
                        getImageCaption: function(obj){
                            return obj.caption;
                        }
                    },
                    instance = PhotoSwipe.attach( 
                        [
                            <?php
                            $imgs = '';
                            for( $a = 0; $a < count( $this->images ); $a++ ){
                                $path = ($this->images[$a]->remote == 1) ? $this->images[$a]->path : $this->folder;
                                $img_path = $path.$this->images[$a]->fname.$this->images[$a]->type;
                                $imgtitle = ($this->images[$a]->title) ? addslashes($this->images[$a]->title) : addslashes(preg_replace('/\s+/', ' ', trim($this->p->street_address)));
                                $imgs .= "{url: '".$img_path."', caption: '".$imgtitle."'},";
                            }
                            echo substr($imgs, 0, -1);
                            ?>
                        ], 
                        options 
                    );

                    instance.show(0);

            }, false);


        }(window, window.Code.PhotoSwipe));
    </script>
    <?php
}else{

    $bodystyle = 'body{min-width: '.$this->gallerywidth.'px !important;}.rt-container{ width: '.($this->gallerywidth + 20).'px !important;}';
    $doc->addStyleDeclaration($bodystyle);
    
    switch($this->settings->gallerytype)
    {
        case 1: ?>
            <!-- Original Slideshow Layout -->
            <div align="center">
                <div id="viewer_control" style="width:<?php echo $this->gallerywidth; ?>px;">
                    <ul>
                        <li><a href='javascript:void(0)' onclick='gl.stopSls();gl.firstPic();'><img src="<?php echo JURI::base(true); ?>/components/com_iproperty/assets/galleries/viewer/btn_first.png" alt="First Image" title="First Image" border="0" /></a></li>
                        <li><a href='javascript:void(0)' onclick='gl.stopSls();gl.previousPic();'><img src="<?php echo JURI::base(true); ?>/components/com_iproperty/assets/galleries/viewer/btn_back.png" alt="Back" title="Back" border="0" /></a></li>
                        <li><a href='javascript:void(0)' onclick='gl.stopSls();'><img src="<?php echo JURI::base(true); ?>/components/com_iproperty/assets/galleries/viewer/btn_pause.png" alt="Pause" title="Pause" border="0" /></a></li>
                        <li><a href='javascript:void(0)' onclick='gl.stopSls();gl.nextPic();'><img src="<?php echo JURI::base(true); ?>/components/com_iproperty/assets/galleries/viewer/btn_fwd.png" alt="Forward" title="Forward" border="0" /></a></li>
                        <li><a href='javascript:void(0)' onclick='gl.stopSls();gl.lastPic();'><img src="<?php echo JURI::base(true); ?>/components/com_iproperty/assets/galleries/viewer/btn_last.png" alt="Last Image" title="Last Image" border="0" /></a></li>
                        <li><a href='javascript:void(0)' onclick='gl.startSls();'><img src="<?php echo JURI::base(true); ?>/components/com_iproperty/assets/galleries/viewer/btn_slideshow.png" alt="Slideshow" title="Slideshow" border="0" /></a></li>
                        <li><a href='javascript:void(0)' onclick='gl.fasterSls();'><img src="<?php echo JURI::base(true); ?>/components/com_iproperty/assets/galleries/viewer/btn_faster.png" alt="Speed Up" title="Speed Up" border="0" /></a></li>
                        <li><a href='javascript:void(0)' onclick='gl.slowerSls();'><img src="<?php echo JURI::base(true); ?>/components/com_iproperty/assets/galleries/viewer/btn_slower.png" alt="Slow Down" title="Slow Down" border="0" /></a></li>
                    </ul>
                </div>
                <div>
                <div id="viewer_img">
                    <img name="ipimage" id="ipimage" alt="" border="0" onClick="javascript:gl.stopSls();gl.nextPic()" />
                </div>
                </div>
            </div>
            <!-- end original slideshow layout -->
    <?php 
        break;
        case 2:
    ?>
            <!-- noob layout slideshow -->
            <div class="vtour_slideshow_container" align="center">
                <div class="mask2" align="left">
                    <div id="box5">
                        <?php
                        for( $a = 0; $a < count( $this->images ); $a++ ){
                            $path = ($this->images[$a]->remote == 1) ? $this->images[$a]->path : $this->folder;
                            $img_path = $path.$this->images[$a]->fname.$this->images[$a]->type;
                            echo '<span><img src="'. $img_path .'" alt="" border="0" /></span>';
                        }
                        ?>
                    </div>
                    <div id="info5" class="gallery_info">
                        <div class="vt_slideshow_info">
                            <div class="vt_slideshow_h1" id="imgtitle"><?php echo ($this->images[0]->title) ? $this->images[0]->title : preg_replace('/\s+/', ' ', trim($this->p->street_address)); ?></div><br />
                            <div class="vt_slideshow_h1desc" id="imgdesc"><?php echo ($this->images[0]->description) ? $this->images[0]->description : $this->p->city.' '.ipropertyHTML::getStateName($this->p->locstate).$this->p->province; ?></div>
                        </div>
                    </div>
                </div>
                <div id="box5_buttons">
                <p class="buttons">
                    <span id="next5" class="vt_slideshow_btn"></span>
                    <span id="play5" class="vt_slideshow_btn"></span>
                    <span id="stop5" class="vt_slideshow_btn"></span>
                    <span id="prev5" class="vt_slideshow_btn"></span>
                </p>
                </div>
            </div>
            <!-- end noob layout slideshow -->
    <?php
        break;
    }    
}
?>