<div style="display:none;">
    <?php if ($callbackphone_active_rightside == "2") { ?>
    <div id="callbackphone" class="showonesides">
    <?php } else { ?>
    <div id="callbackphone" class="showtwosides">
    <?php } ?>
        <div id="callbackphone-left">
            <div id="callbackphone-left-head"><?php echo $callbackphone_title; ?></div>
            <?php if ($callbackphone_active_rightside == "2") { ?>
               <span onclick="$.modal2.close();" class="modalCloseImg"></span>
            <?php } ?>
            
            <div id="callbackphone-left-forma">
                <form action="" id="callbackphone-form" >
                    <input type="text" name="callbackphonename" id="callbackphonename" placeholder="<?php echo $text_placeholder_name; ?>" class="callbackphone-left-forma-input" /><div class="callbackphone-left-forma-input-req"></div>
                    <br />
                    <input type="text" name="callbackphonetel" id="callbackphonetel" placeholder="<?php echo $text_placeholder_telphone; ?>" class="callbackphone-left-forma-input" /><div class="callbackphone-left-forma-input-req"></div>
                    <br />
                    <?php if ($callbackphone_active_time == "1") { ?>
                    <input type="text" name="callup" id="callup" class="callbackphone-left-forma-inputtime" placeholder="<?php echo $text_placeholder_callup; ?>" /> <input type="text" name="callto" class="callbackphone-left-forma-inputtime" id="callto" placeholder="<?php echo $text_placeholder_callto; ?>" />
                    <br />
                    <?php } ?>
                    <?php if ($callbackphone_active_comment == "1") { ?>
                    <textarea type="text" name="callbackphonecomment" id="callbackphonecomment" placeholder="<?php echo $text_placeholder_comment; ?>" class="callbackphone-left-forma-input"></textarea>
                    <br />
                    <?php } ?>
                    <div style="width:90%;text-align:center;margin-bottom:40px;"><a onclick="send();"><img src="image/callbackphone/sendcallbackphone.png" /></a></div>
                </form>
                
            </div>
            <div id="callbackphone-left-required"><?php echo $callbackphone_required; ?></div>
            <div id="callbackphone-result"></div>
        </div>
        <?php if ($callbackphone_active_rightside == "1") { ?>
        <div id="callbackphone-right">
            <div id="callbackphone-right-head">НАШИ КОНТАКТЫ</div><span onclick="$.modal2.close();" class="modalCloseImg"></span>
            <div id="callbackphone-right-contacts">
                <table>
                    <?php if ($callbackphone_active_tel == "1") { ?>
                    <tr>
                        <td class="callbackphone-right-contacts-td-tel"><img src="image/callbackphone/callbackphone-tel-ico.png" /></td>
                        <td class="callbackphone-right-contacts-tel"><?php echo $callbackphone_telephone = empty($callbackphone_telephone) ? $config_telephone :  $callbackphone_telephone; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($callbackphone_active_fax == "1") { ?>
                    <tr>
                        <td class="callbackphone-right-contacts-td-tel"><img src="image/callbackphone/callbackphone-fax-ico.png" /></td>
                        <td class="callbackphone-right-contacts-tel"><?php echo $callbackphone_fax = empty($callbackphone_fax) ? $config_fax :  $callbackphone_fax; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($callbackphone_active_email == "1") { ?>
                    <tr>
                        <td class="callbackphone-right-contacts-td-email"><img src="image/callbackphone/callbackphone-email-ico.png" /></td>
                        <td class="callbackphone-right-contacts-email"><?php echo $callbackphone_email = empty($callbackphone_email) ? $config_email :  $callbackphone_email; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($callbackphone_active_address == "1") { ?>
                    <tr>
                        <td class="callbackphone-right-contacts-td-address"><img src="image/callbackphone/callbackphone-address-ico.png" /></td>
                        <td class="callbackphone-right-contacts-address"><?php echo $callbackphone_address = empty($callbackphone_address) ? $config_address :  $callbackphone_address; ?></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php if ($callbackphone_mapshow == "1") { ?>
                    <div id="callbackphone-right-map"><?php echo $callbackphone_map = empty($callbackphone_map) ? "" :  $callbackphone_map; ?></div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
function send() {
var callbackphonename = $('#callbackphonename').val();
var callbackphonetel = $('#callbackphonetel').val();
var callup = $('#callup').val();
var callto = $('#callto').val();
var callbackphonecomment = $('#callbackphonecomment').val();

       $.ajax({
                type: "POST",
                url: "/index.php?route=module/callbackphone/send",
                data: 'callbackphonename=' + callbackphonename + '&callbackphonetel=' + callbackphonetel + '&callup=' + callup + '&callto=' + callto + '&callbackphonecomment=' + callbackphonecomment,
                success: function(html) {
                        $("#result").empty();
                        $("#callbackphone-left-forma").hide();
                        $("#callbackphone-result").append(html);
                }
        });
}
</script>

<script type="text/javascript">
  callbackphone=jQuery.noConflict();
      jQuery(document).ready(function() { 
        callbackphone('#callup').datetimepicker();
        callbackphone('#callto').datetimepicker();
        callbackphone('#callbackphonetel').mask('<?php echo $callbackphone_mask; ?>');
      });
  $=jQuery.noConflict();
</script>

<script type="text/javascript">
function hasPlaceholderSupport() {
  var input = document.createElement('input');
  return ('placeholder' in input);
}

if(!hasPlaceholderSupport()){
    var inputs = $('input');
    for(var i=0,  count = inputs.length;i<count;i++){
        if(inputs[i].getAttribute('placeholder')){
            inputs[i].style.cssText = "color:#777;"
            inputs[i].value = inputs[i].getAttribute("placeholder");
            inputs[i].onclick = function(){
                if(this.value == this.getAttribute("placeholder")){
                    this.value = '';
                    this.style.cssText = "color:#777;"
                }
            }
            inputs[i].onblur = function(){
                if(this.value == ''){
                    this.value = this.getAttribute("placeholder");
                    this.style.cssText = "color:#777;"
                }
            }
        }
    }
}
</script>