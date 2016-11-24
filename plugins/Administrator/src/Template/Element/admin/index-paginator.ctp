<?php #paginador de los index de los controladores. ?>

<section class="up-section counter-section fondo5">
                            <div class="table">

                                <div class="table-cell">
                                    <div class="div-btn_delete">
                                        <?php echo $this->Form->button(__($controllerText['trash_restore']), ['type' => 'submit', 'label' => false, 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->view, 'div' => false]); ?>                      
                                        <span><?php echo __($extras['all_selection']); ?></span> 
                                    </div>
                                </div>

                                <div class="table-cell pagin-count">
                                    <p><?php echo $this->Paginator->counter(['format' => ''.__($extras['page']).' {{page}} '.__($extras['of']).' {{pages}}, '.__($extras['showing']).' {{current}} '.__($extras['log']).' {{count}}']);?></p>
                                    <nav>
                                        <?php echo $this->Paginator->prev('');
                                              echo $this->Paginator->numbers(array('separator' => ' - ','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
                                              echo $this->Paginator->next(''); ?>
                                    </nav>
                                </div>

                            </div>
</section>