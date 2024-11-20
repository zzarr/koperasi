<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span id="action-modal"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="user-form" data-id="" data-userId="">
                    @csrf
                    <div class="form-group">
                        <label>Tanggal Bayar <span class="text-danger">*</span> </label>
                        <input type="text" name="paid_at" class="form-control" id="paid_at" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Jumlah <span class="text-danger">*</span> </label>
                        <input type="text" name="amount" class="form-control" id="amount" placeholder="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                    Close</button>
                <button type="button" id="btn_form" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
