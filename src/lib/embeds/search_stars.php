<?php
namespace Space;

$search_count = 0; //For scope reasons
$range = 5; //The number of results to present for each page
$start_index = (isset($_GET["start_index"])) ? $_GET["start_index"] : 0; //The index to start from

if (empty($search_content)) {
    echo "<h4 align='center'>Sem conteúdo para pesquisar...</h4>";
} else {
    $ids = Star::Search($search_content);

    if (is_bool($ids)) {
        echo "<h4 align='center'>Ocorreu um erro durante a pesquisa...</h4>";
    } else if (count($ids) < 1) {
        echo "<h4 align='center'>Nenhum resultado...</h4>";
    } else {
        $search_count = count($ids);
        if ($start_index >= $search_count)
            $start_index = 0;
        if ($range > $search_count)
            $range = $search_count;

        for ($row = $start_index; $row < $start_index + $range; $row++) {
            if ($row < 0 || $row >= $search_count)
                break; //Out of the valid indexes
            $star = new Star($ids[$row]["id"]);
            
            include("star_div.php");
        }
    }
}
?>