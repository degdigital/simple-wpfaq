<?php
/**
 * Class getFAQ
 * @todo Move the more of the query here.
 */
class getFAQ {

    function __construct() {

        $this->categories = get_categories(array(
            'orderby' => 'name',
            'order' => 'ASC',
            'taxonomy' => 'faq_category'
        ));

    }

    function categories($field = '') {
        if ( $field != '' ) {
            return $this->categories[0]->$field;
        } else {
            return $this->categories[0];
        }
    }
}