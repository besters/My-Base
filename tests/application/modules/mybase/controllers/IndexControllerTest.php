<?php

class IndexControllerTest extends ControllerTestCase
{
    public function testNeprihlasenyUzivatelByMelBytPresmerovanNaAuthAction()
    {
        $this->request->setQuery(array('account' => 'unodor'));
        $this->dispatch('/mybase/index/index');
        $this->assertRoute('default');
        $this->assertController('auth');
        $this->assertAction('login');
        $this->assertQueryCount('div#loginbox', 1); //obsahuje formular
    }
}