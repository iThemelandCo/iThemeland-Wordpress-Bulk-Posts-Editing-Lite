<?php


namespace wpbel\classes\lib;


class WpbelPostsTaxonomyWalker extends \Walker_Category
{
    var $lev = -1;
    var $skip = 0;
    private $checked;

    public function __construct(array $checked = [])
    {
        $this->checked = $checked;
    }

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $this->lev = 0;
        $output .= "<ul>" . PHP_EOL;
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= "</ul>" . PHP_EOL;
        $this->lev = -1;
    }

    function start_el(&$output, $taxonomy, $depth = 0, $args = array(), $id = 0)
    {
        $taxonomy_name = esc_attr($taxonomy->name);
        $taxonomy_id = ($taxonomy->taxonomy == 'category') ? esc_attr(intval($taxonomy->term_id)) : esc_attr($taxonomy->name);
        $checked = (is_array($this->checked) && in_array($taxonomy_id, $this->checked)) ? 'checked="checked"' : '';
        $output .= "<li><label><input type='checkbox' data-taxonomy-name='" . esc_attr($taxonomy_name) . "' value='" . esc_attr($taxonomy_id) . "' " . esc_attr($checked) . ">" . esc_html($taxonomy_name) . "</label>";
    }

    function end_el(&$output, $page, $depth = 0, $args = array())
    {
        $this->lev++;
        if ($this->skip == 1) {
            $this->skip = 0;
            return;
        }
        $output .= "</li>" . PHP_EOL;
    }
}
