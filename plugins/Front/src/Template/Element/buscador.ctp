
<!-- buscador principal -->
    <section class="buscador opacity <?= $this->request->params['controller']; ?>">
    
                          <h2 class="search_title color0"><?= __($extras['search_title']); ?></h2>

                          <?php $datos = ['Category' =>     ['label' => false, 'type' => 'select', 'options' => $this->Get->get_list_categories(), 'empty' => __($extras['type'])], 
                                          'country' =>      ['label' => false, 'placeholder' => __($extras['country']), 'class' => 'country', 'type' => 'select', 'empty' => __($extras['country'])], 
                                          'state' =>         ['label' => false, 'placeholder' => __($extras['state']), 'class' => 'state', 'type' => 'select',  'empty' => __($extras['state'])], 
                                          'postal_code' =>  ['label' => false, 'placeholder' => __($extras['postal_code'])], 
                                          'avalible' =>     ['label' => false, 'type' => 'select', 'empty' => __($extras['avalible_for']), 'options' => $avalible ], 
                                          'tons_since' =>   ['type' => 'hidden', 'value' => 0],
                                          'model' =>        ['type' => 'hidden', 'value' => ''],
                                          'tons_until' =>   ['type' => 'hidden', 'value' => 3000],
                                          //'year_since' =>   ['type' => 'hidden', 'value' => 1900],
                                          //'year_until' =>   ['type' => 'hidden', 'value' => date('Y')],
                                          __($extras['search_submit']) => ['id' => 'Buscar', 'label' => false, 'type' => 'submit', 'class' => 'submit', 'value' => __($extras['search_submit']) ], 
                                   ]; ?>

                          <?= $this->Form->create('search', ['url' => $this->Get->get_url_translate('Search', 'index'), 'type' => 'get', 'id' => 'search']); ?>
                              <?php foreach ($datos as $name => $options) { ?>
                                    <?= $this->Form->input($name, $options); ?>
                              <?php } ?>
                          <?= $this->Form->end(); ?>

    </section>
<!-- fin buscador principal -->


