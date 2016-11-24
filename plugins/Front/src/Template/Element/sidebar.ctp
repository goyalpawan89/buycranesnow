<?= $this->Html->css('front/jquery.nstSlider.min'); // css del slide de precios
    echo $this->Html->css('front/jquery-ui'); // css jquery UI. ?>


                    <!-- buscador sidebar -->
                    <aside class="content-table_sidebar">
                        <?= $this->Form->create('search', ['id'=>'sidebarSearch', 'url' => $this->Get->get_url_translate('Search', 'index'), 'type' => 'get', ]); ?>

                                  <h2 class="content-table_sidebar_title"><?= __($extras['filter']); ?></h2>

                                  <?= $this->Form->input('Category', ['type' => 'select', 'class' => 'input-form', 'options' => $this->Get->get_list_categories(), 'value' => $sidebarData['Category'], 'label' => false, 'empty' => __($extras['type']) ]); ?>
                                  
                                  <!-- input tons -->
                                  <div class="input tons">
                                    <span class="price-side"><?= __($extras['since']); ?> <font><?= __('(t)'); ?></font></span> <span class="price-side"><?= __($extras['until']); ?> <font><?= __('(t)'); ?></font></span>
                                    <?= $this->Form->input('tons_since', ['label' => false, 'class' => 'since-until', 'type' => 'number', 'value' => $sidebarData['tons_since'], 'step' => 5, 'min' => '0', 'placeholder' => $sidebarData['tons_since']]); ?>
                                    <?= $this->Form->input('tons_until', ['label' => false, 'class' => 'since-until', 'type' => 'number', 'value' => $sidebarData['tons_until'], 'step' => 5, 'placeholder' => $sidebarData['tons_until']]); ?>
                                  </div>
                                  <!-- input tons -->


                                  <!-- input others -->
                                  <?php foreach ($fieldsPosts as $field) { 
                                        $option = json_decode($field->option_value);
                                        $selectOptions = explode(',', $option->options);
                                        $opts = array_combine($selectOptions, $selectOptions);

                                        if($field->option_key == 'avalible'){

                                          $opciones = $avalible;

                                        }
                                        
                                        elseif($field->option_key == 'country'){

                                          $opciones = [];

                                        }

                                        elseif($field->option_key == 'continent') {

                                            $opciones = $continentes;    

                                        } else { 

                                          $opciones = $opts; 
                                        }

                                echo $this->Form->input($field->option_key, ['type' => $option->input, 'label' => false, 'class' => 'input-form', 'options' => $opciones, 'value' => $sidebarData[$field->option_key], 'class' => $field->option_key, 'placeholder' => __($extras[$field->option_key]), 'empty' => __($extras[$field->option_key]) ]);
                                
                                        }
                                  ?>

                                  <!-- modelos agregados manualmente para el select -->
                                    <?= $this->Form->input('model', ['type' => 'select', 'class' => 'select-model input', 'options' => $modelCranes, 'value' => $sidebarData['model'], 'label' => false, 'empty' => __($extras['model']) ]); ?>

                                  <!-- fin input others -->

                                  <?= $this->Form->button(__($extras['search_submit']), ['label' => false, 'class' => 'btn-search btn btn-link fondo1 fondoh2 color3 colorh0']); ?>
                                  <?= $this->Form->button(__($extras['reset']), ['label' => false, 'class' => 'btn-search btn btn-link fondo3 fondoh2 color0']); ?>

                                 
                        
                        <?= $this->Form->end(); ?>


                    </aside>
                    <!-- fin buscador sidebar -->
                    


                    <?= $this->Html->script('front/jquery.nstSlider.min'); // scritp de precio con slider ?>


                    <script type="text/javascript">

                    //limitar maximo y minimo en el campo años.
                    (function ($) {
                            $.fn.restrict = function () {
                                return this.each(function(){
                                    if (this.type && 'number' === this.type.toLowerCase()) {
                                        $(this).on('change', function(){
                                            var _self = this,
                                                v = parseFloat(_self.value),
                                                min = parseFloat(_self.min),
                                                max = parseFloat(_self.max);
                                            if (v >= min && v <= max){
                                                _self.value = v;
                                            }
                                            else {
                                                _self.value = v < min ? min : max;
                                            }
                                        });
                                    }
                                });
                            };
                        })(jQuery);

                        $('.yearUntil').restrict();
                        $('.yearSince').restrict();
                        
                          
                          //buscar las ciudades por pais
                          $(document).ready(function() {


                                  //comparar toneladas
                                  $('#tons-since').change(function(){
                                        var since = $(this).val();
                                        var until = $('#tons-until').val();
                                        
                                        var sinceTons = parseInt(since) + 5;
                                        $('#tons-until').val(sinceTons).attr('min', sinceTons);

                                  });

                                  //validar el rango de años
                                  $('#year-since').change(function(){
                                        var since = $(this).attr('value');
                                        $('#year-until').attr('value', since).attr('min', since);
                                  });

                    });



                    </script>