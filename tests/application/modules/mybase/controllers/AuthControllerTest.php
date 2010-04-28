<?php

class AuthControllerTest extends ControllerTestCase
{
    public function testValidLoginShouldGoToIndexPage()
    {
        $this->request->setQuery(array('account' => 'unodor'));

        $this->request->setMethod('POST')
              ->setPost(array(
                  'email' => 'marchlik@unodor.cz',
                  'password' => '2981986'
              ));

        $this->dispatch('/mybase/auth/login');
        
        $this->assertRedirectTo('/');

        $this->resetRequest()->resetResponse();
 
        $this->request->setQuery(array('account' => 'unodor'));
        $this->dispatch('/mybase');
        $this->assertRoute('default');
        $this->assertModule('mybase');
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertNotRedirect();
        $this->assertQuery('div#mainmenu');
        $this->assertNotQuery('div#submenu');

        $this->assertQueryContentContains('a.user', 'Daniel Marchlik');

    }
}