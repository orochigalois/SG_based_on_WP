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
                    
                    if(isset($user_info['tts'])){
                        if($user_info['tts'][0]=='voicerss')
                        {
                            echo '<option value="google">Google</option>';
                            echo '<option value="voicerss" selected="selected">Voicerss</option>';
                        }
                        else
                        {
                            echo '<option value="google" selected="selected">Google</option>';
                            echo '<option value="voicerss">Voicerss</option>';
                        }
                    }
                    else
                    {
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



add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'tts', $_POST['tts'] );
}
