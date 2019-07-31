

<?php
global $wpdb;
global $current_user;

$user = wp_get_current_user();
$main_entry = get_user_meta($user->ID, 'main_entry', true);

if ($main_entry == "sentence") {
    echo "<table><tr>
    <th>sentence</th>
    <th>date</th>
    </tr>";

    $all_ids = $wpdb->get_results(
        "
        SELECT a.ID,a.post_date from {$wpdb->posts} a left join {$wpdb->postmeta} b on a.id=b.post_id WHERE post_author='{$current_user->ID}' and meta_key='main_entry' and meta_value='sentence'
        "
    );

    foreach ($all_ids as $all_id) {
        $filepath = get_attached_file($all_id->ID);
        $csvdata = file_get_contents($filepath);
        $lines = explode(".", $csvdata);
        foreach ($lines as $i => $line) {
            if (trim($line) != "") {
                echo "<tr>";
                echo "<td>" . trim($line) . "</td>";
                echo "<td style='width:150px;'>" . $all_id->post_date . "</td>";
                echo "</tr>";
            }
        }
    }
    echo "</table>";
} else {

    echo "<table><tr>
<th>word</th>
<th>sentence</th>
<th>date</th>
</tr>";

    $all_ids = $wpdb->get_results(
        "
	SELECT a.ID,a.post_date from {$wpdb->posts} a left join {$wpdb->postmeta} b on a.id=b.post_id WHERE post_author='{$current_user->ID}' and meta_key='main_entry' and meta_value='word'
    "
    );

    foreach ($all_ids as $all_id) {
        $filepath = get_attached_file($all_id->ID);
        $csvdata = file_get_contents($filepath);
        $lines = explode("\n", $csvdata); // split data by new lines

        foreach ($lines as $i => $line) {
            echo "<tr>";
            $values = explode(',', $line, 2); // split lines by commas
            echo "<td>" . trim($values[0]) . "</td>";
            unset($values[0]);
            if (isset($values[1])) {
                echo "<td>" . trim($values[1]) . "</td>";
                unset($values[1]);
            } else {
                echo "<td></td>";
            }
            echo "<td style='width:150px;'>" . $all_id->post_date . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}





?>