

<!-- seccion principal -->
            <section class="content">
                    
                    <section class="up-section section fondo5">
                            <div class="table">
                                <div class="table-cell">
                                    <h1 class="principal color1"><?php echo __($controllerText['title']); ?></h1>
                                    <p class="principa-description"><?php echo __($controllerText['description']); ?></p>
                                </div>

                                <div class="table-cell">

                                <?php 

                                    if($this->request->params['controller'] !='Generals') { 

                                    if($this->request->params['action'] =='index' || $this->request->params['action']=='trash') { ?>

                                    <p>
                                        <?php // conteo del controlador (todos, activos inactivos)
                                        $dataCount = ['all' => ['text' => $todos, 'action' => 'index'], 'active' => ['text' => $activos, 'action' => 'index'], 'inactive' => ['text' => $inactivos, 'action' => 'trash']]; 
                                        foreach ($dataCount as $key => $dato) { ?>
                                            <span><?php echo __($controllerText[$key]); ?>:</span> <?php echo $this->Html->link($dato['text']. " ". __($extras[$this->name]), ['action' => $dato['action']], ['class' => 'color2 colorh3']); ?> | 
                                        <?php } // fin conteo coltrolador ?>
                                    </p>

                                 

                                    <div class="div-btn_delete">
                                        <span><?php echo __($extras['all_selection']); ?></span> 
                                        <?php echo $this->Form->button(__($controllerText['trash_restore']), ['type' => 'submit', 'label' => false, 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action'], 'div' => false]); ?>                      
                                    </div>

                                <?php } } ?>

                                </div>
                            </div>
                    </section>

            </section>

<!-- fin seccion principal -->

