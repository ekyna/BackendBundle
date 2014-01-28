<?php

namespace Ekyna\BackendBundle\Menu;

use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Main menu builder.
 */
class BackendMenuBuilder extends MenuBuilder
{
    /**
     * Builds backend main menu.
     *
     * @param Request $request
     *
     * @return ItemInterface
     */
    /*public function createMainMenu(Request $request)
    {
        $this->pool->prepare();
        
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($request->getRequestUri());

        $childOptions = array(
            'attributes'         => array('class' => 'dropdown'),
            'childrenAttributes' => array('class' => 'dropdown-menu'),
            'labelAttributes'    => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
        );

        $menu->addChild('dashboard', array(
            'route' => 'ekyna_backend_dashboard'
        ))->setLabel('ekyna.admin.menu.dashboard');
        
        $this->appendChilds($menu, $childOptions);
        
        $menu->addChild('homepage', array(
            'route' => 'ekyna_homepage'
        ))->setLabel('ekyna.admin.menu.homepage');

        return $menu;
    }*/

    /**
     * Builds backend sidebar menu.
     *
     * @param Request $request
     *
     * @return ItemInterface
     */
    public function createSideMenu(Request $request)
    {
        $this->pool->prepare();
        
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => array(
                'id' => 'dashboard-menu'
            )
        ));

        //$menu->setCurrent($request->getRequestUri());

        $childOptions = array(
            'childrenAttributes' => array(),
            'labelAttributes'    => array()
        );
        
        $menu
            ->addChild('dashboard', array(
                'route' => 'ekyna_backend_dashboard',
                'labelAttributes' => array('icon' => 'dashboard'),
            ))
            ->setLabel('ekyna.admin.menu.dashboard')
        ;
        
        $menu
            ->addChild('pages', array(
                'route' => 'ekyna_backend_page_index',
                'labelAttributes' => array('icon' => 'file'),
            ))
            ->setLabel('ekyna.page.label.plural')
        ;
        
        $this->appendChilds($menu, $childOptions);

        return $menu;
    }
    
    protected function appendChilds($menu, $childOptions)
    {
        foreach($this->pool->getGroups() as $group) {
            
            $groupOptions = array(
                'labelAttributes' => array('icon' => $group->getIcon()),
                'childrenAttributes' => array('class' => 'submenu')
            );
            if($group->hasEntries()) {
                $groupOptions['labelAttributes']['class'] = 'dropdown-toggle';
            }else{
                $groupOptions['route'] = $group->getRoute();
            }
            $child = $menu
                ->addChild($group->getName(), $groupOptions)
                ->setLabel($this->translate($group->getLabel(), array(), $group->getDomain()))
            ;
            if($group->hasEntries()) {
                foreach($group->getEntries() as $entry) {
                    $child->addChild($entry->getName(), array(
                        'route' => $entry->getRoute()
                    ))->setLabel($this->translate($entry->getLabel(), array(), $entry->getDomain()));
                }
            }
        }
    }
}
