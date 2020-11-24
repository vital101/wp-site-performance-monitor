<?php

class Api {

    public function __construct() {
        // WIP
    }

    public function status(WP_REST_Request $request) {
        $optionStatus = get_option('kernl-spm-setup-complete', false);
        if (!$optionStatus) {
            add_option('kernl-spm-setup-complete', false);
        }
        return $optionStatus;
    }
}

?>