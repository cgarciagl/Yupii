<?php echo $this->load->view('process/partial_header', NULL, TRUE); ?>

<div class="container">
    <div class="row">
        <hr/>
        <div class="col-md-4 col-md-offset-3" id="divprogreso">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" id="titulopbar"><i class="fa fa-cog fa-spin fa-2x" id="girando"></i> <span
                            id="textotitulo">Procesando...</span></h3>
                </div>
                <div class="panel-body">
                    <h4 id="textopbar"> Procesando...</h4>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" id="pbar">
                            0%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
