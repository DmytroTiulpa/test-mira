<?php

class View
{

    public function render($tpl, $pageData)
    {
		//print ROOT.$tpl;
        include ROOT.$tpl;
    }

}
