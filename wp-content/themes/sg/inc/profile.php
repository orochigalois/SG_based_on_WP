<?php

add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');

function extra_user_profile_fields($user)
{ ?>
    <h2><?php _e("Setting", "blank"); ?></h2>



    <table class="form-table">
        <tbody>
            <tr class="user-tts-wrap">
                <th scope="row">
                    <label for="tts">TTS</label>
                </th>
                <td>
                    <select name="tts" id="tts">

                        <?php
                            $user = wp_get_current_user();
                            $user_info = get_user_meta($user->ID);

                            if (isset($user_info['tts'])) {
                                if ($user_info['tts'][0] == 'voicerss') {
                                    echo '<option value="google">Google</option>';
                                    echo '<option value="voicerss" selected="selected">Voicerss</option>';
                                } else {
                                    echo '<option value="google" selected="selected">Google</option>';
                                    echo '<option value="voicerss">Voicerss</option>';
                                }
                            } else {
                                echo '<option value="google" selected="selected">Google</option>';
                                echo '<option value="voicerss">Voicerss</option>';
                            }
                            ?>
                    </select> </td>
            </tr>


        </tbody>
    </table>


<?php


}



add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'tts', $_POST['tts']);
}



add_action('show_user_profile', 'show_token', 11);
add_action('edit_user_profile', 'show_token', 11);


function show_token($user)
{
    $sg_user_token = get_user_meta($user->ID, 'sg_user_token', true);
    // $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
    // $domainName = $_SERVER['SERVER_NAME'];
    ?>
    <h2><?php _e("Token", "blank"); ?></h2>



    <table class="form-table">
        <tbody>
            <tr class="user-tts-wrap">
                <th scope="row">
                    <label for="tts">Your token:</label>
                </th>
                <td>
                    <?= $sg_user_token; ?>
                </td>
            </tr>

            <tr class="user-tts-wrap">
                <th scope="row">
                    <label for="tts">How to use it on a Mac?</label>
                </th>
                <td>
                    <p>Step1.Download & Install <a href="http://www.hammerspoon.org/">hammerspoon</a></p>
                    <p>Step2.Click "Open Config"</p>
                    <img src="<?php lp_image_dir(); ?>/step2.png" alt="">
                    <p>Step3.Copy & Paste following code, then save</p>



                    <script src="<?php echo get_template_directory_uri() . '/dist/js/run_prettify.js' ?>"></script>
                    <pre data-lang='lua' class='prettyprint'>
YOUR_TOKEN = "<?= $sg_user_token; ?>";
REMOTE_URL = "<?= site_url(); ?>";

hs.hotkey.bind({"cmd", "alt", "ctrl"}, "0", function()

    local text = current_selection()
    local url = REMOTE_URL ..
                    "/wp-admin/admin-ajax.php?action=collect_sentence&sentence=" ..
                    encodeURI(text) .. ".&sg_user_token=" .. YOUR_TOKEN

    local res = hs.urlevent.openURL(url)
    print(res)
    hs.alert.show(text)
end)

hs.hotkey.bind({"cmd", "alt", "ctrl"}, "1", function()

    local text = current_selection()
    local url = REMOTE_URL ..
                    "/wp-admin/admin-ajax.php?action=collect_word&word=" ..
                    encodeURI(text) .. "&sg_user_token=" .. YOUR_TOKEN

    local res = hs.urlevent.openURL(url)
    print(res)
    hs.alert.show(text)
end)

hs.hotkey.bind({"cmd", "alt", "ctrl"}, "2", function()

    local text = current_selection()
    local url = REMOTE_URL ..
                    "/wp-admin/admin-ajax.php?action=collect_sentence_for_word&sentence=" ..
                    encodeURI(text) .. "&sg_user_token=" .. YOUR_TOKEN

    local res = hs.urlevent.openURL(url)
    print(res)
    hs.alert.show(text)
end)

function encodeURI(str)
    if (str) then
        str = string.gsub(str, "\n", "\r\n")
        str = string.gsub(str, "([^%w ])", function(c)
            return string.format("%%%02X", string.byte(c))
        end)
        str = string.gsub(str, " ", "+")
    end
    return str
end

function current_selection()
    hs.eventtap.keyStroke({"cmd"}, "c")
    hs.timer.usleep(20000)
    sel = hs.pasteboard.getContents()
    return (sel or "")
end


</pre>
                    <p>Step4.Click "Reload Config"</p>
                    <img src="<?php lp_image_dir(); ?>/step4.png" alt="">
                    <p>All done! You can use the shortcut "cmd" + "alt" + "ctrl" + "0" to collect a sentence.</p>
                    <p>Use the shortcut "cmd" + "alt" + "ctrl" + "1" to collect a word.</p>
                    <p>Use the shortcut "cmd" + "alt" + "ctrl" + "2" to collect a sentence after a word.</p>
                </td>
            </tr>


        </tbody>
    </table>


<?php


}
