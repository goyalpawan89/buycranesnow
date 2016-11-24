<!-- buscador principal -->
    <section id="buscador_post" class="buscador fondo2">
                          <h2 class="search_title color0"><?php echo __($extras['search_title']); ?></h2>

                          <?php $datos = ['Category' =>     ['label' => false, 'type' => 'select', 'options' => $this->Get->get_list_categories()], 
                                          'country' =>      ['label' => false, 'placeholder' => __($extras['country']) ], 
                                          'city' =>         ['label' => false, 'placeholder' => __($extras['city'])], 
                                          'postal_code' =>  ['label' => false, 'placeholder' => __($extras['postal_code'])], 
                                          'avalible' =>     ['label' => false, 'type' => 'select', 'empty' => __($extras['select_default']), 'options' => $avalible ], 
                                          'tons_since' =>   ['type' => 'hidden', 'value' => 1],
                                          'tons_until' =>   ['type' => 'hidden', 'value' => 100000],
                                          'year_since' =>   ['type' => 'hidden', 'value' => 1900],
                                          'year_until' =>   ['type' => 'hidden', 'value' => date('Y')],
                                          __($extras['search_submit']) => ['id' => 'Buscar', 'label' => false, 'type' => 'submit', 'class' => 'submit', 'value' => __($extras['search_submit']) ], 
                                   ]; ?>

                          <?= $this->Form->create('search', ['url' => ['controller' => 'Search', 'action' => 'index'], 'type' => 'get', 'id' => 'search']); ?>
                              <?php foreach ($datos as $name => $options) { ?>
                                    <?php echo $this->Form->input($name, $options); ?>
                              <?php } ?>
                          <?php echo $this->Form->end(); ?>

    </section>
<!-- fin buscador principal -->

