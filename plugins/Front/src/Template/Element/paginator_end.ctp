<section class="up-section counter-section fondo5 paginator_comany">
                            <div class="wrap">
                                <div class="pagin-count">
                                    <p><?= $this->Paginator->counter(['format' => ''.__($extras['page']).' {{page}} '.__($extras['of']).' {{pages}}, '.__($extras['showing']).' {{current}} '.__($extras['log']).' {{count}}']);?></p>
                                    <nav>
                                        <?= $this->Paginator->prev('');
                                              echo $this->Paginator->numbers(['separator' => ' - ','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1]);
                                              echo $this->Paginator->next(''); ?>
                                    </nav>
                                </div>
                            </div>
      </section>