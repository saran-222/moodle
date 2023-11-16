<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * TODO describe file index
 *
 * @package    local_greetings
 * @copyright  2023 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 require('../../config.php');
 require($CFG->dirroot. '/local/greetings/lib.php');




// global $USER;



$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_url(new moodle_url('/local/greetings/index.php'));

$PAGE->set_pagelayout('standard');

$PAGE->set_title($SITE->fullname);


// $PAGE->set_heading(get_string('pluginname', 'local_greetings'));


$messageform = new \local_greetings\form\message_form();

if ($data = $messageform->get_data()) {
    $message = required_param('message', PARAM_TEXT);

    if(!empty($message)){
        $record = new stdClass;
        $record->message = $message;
        $record->timecreated = time();
        $record->userid = $USER->id;

        $DB->insert_record('local_greetings_messages',$record);
    }
}

// $PAGE->requires->css(new moodle_url('/local/greetings/styles/form.css'));

$userfields = \core_user\fields::for_name()->with_identity($context);
$userfieldssql = $userfields->get_sql('u');

$sql = "SELECT m.id, m.message, m.timecreated, m.userid {$userfieldssql->selects}
          FROM {local_greetings_messages} m
     LEFT JOIN {user} u ON u.id = m.userid
      ORDER BY timecreated DESC";

$messages = $DB->get_records_sql($sql);

echo $OUTPUT->header();


// if (isloggedin()) {
//     echo '<h3>Greetings, ' . fullname($USER) . '</h3>';
// } else {
//     echo '<h3>Greetings, user</h3>';
// }

// echo get_string('greeting', 'local_greetings', fullname($USER));
// echo '<br>';
// echo get_string('info', 'local_greetings', ['count' => 42, 'from' => fullname($USER)]);
// echo '<br>';
// echo '<input type="text" name="uname" value="' . s($uname) . '">'; 

// $text = "Hello, <h1> alert('Malicious code');</h1>!";
// $cleaned_text = format_text($text,$format =FORMAT_HTML);
// echo $cleaned_text;
echo '<br>';
// echo html_writer::tag('input', '', [
//     'type' => 'text',
//     'name' => 'username',
//     'placeholder' => get_string('typeyourname', 'local_greetings'),
// ]); 
echo '<br>';
// $now = time();
// echo userdate($now);
echo '<br>';
// echo userdate(time(), get_string('strftimedaydate', 'core_langconfig'));
echo '<br>';

// $date = new DateTime("tomorrow", core_date::get_user_timezone_object());
// $date->setTime(0, 0, 0);
// echo userdate($date->getTimestamp(), get_string('strftimedatefullshort', 'core_langconfig'));
echo '<br>';
// $grade = 20.00 / 3;
// echo format_float($grade, 1);

// echo $OUTPUT->footer();
echo '<br>';

// echo local_greetings_get_greeting($USER);

// echo $USER;


// local_greetings_extend_navigation_frontpage(navigation_node $frontpage);

echo '<br>';


$messageform->display();






echo $OUTPUT->box_start('card-columns my-custom-box-class');

foreach($messages as $m){
    echo html_writer::start_tag('div',array('class' => 'card'));
    echo html_writer::start_tag('div',array('class' => 'card-body'));
    echo html_writer::tag('p',$m->message ,array('class' => 'card-text'));
    echo html_writer::tag('p', get_string('postedby', 'local_greetings', $m->firstname), array('class' => 'card-text'));
    echo html_writer::start_tag('p',array('class' => 'card-text'));
    echo html_writer::tag('div',userdate($m->timecreated),array('class' => 'text-muted'));
    echo html_writer::end_tag('p');
    echo html_writer::end_tag('div');
    echo html_writer::end_tag('div');

}



echo $OUTPUT->box_end();



echo $OUTPUT->footer();

// require_login();

// $url = new moodle_url('/local/greetings/index.php', []);
// $PAGE->set_url($url);
// $PAGE->set_context(context_system::instance());

// $PAGE->set_heading($SITE->fullname);
// echo $OUTPUT->header();
// echo $OUTPUT->footer();
