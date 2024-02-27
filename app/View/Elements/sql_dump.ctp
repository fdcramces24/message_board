<?php
// File: app/View/Elements/sql_dump.ctp

if (!empty($logs)) {
    foreach ($logs as $log) {
        echo '<div style="border: 1px solid #ccc; margin-bottom: 10px; padding: 5px;">';
        echo '<strong>Query:</strong> ' . $log['query'];
        echo '<br>';
        if (!empty($log['params'])) {
            echo '<strong>Parameters:</strong> ';
            echo '<pre>';
            print_r($log['params']);
            echo '</pre>';
        }
        echo '<strong>Took:</strong> ' . $log['took'] . ' ms';
        echo '</div>';
    }
} else {
    echo '<div>No SQL queries executed.</div>';
}
?>
