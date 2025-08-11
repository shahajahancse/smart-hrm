<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Vehicle Requisition List</h3>

    <a href="<?= site_url('admin/vehicle_requisition/create') ?>" class="btn btn-primary mb-3 float-right">Request Vehicle</a>
  </div>
  <div class="box-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>SL</th>
          <th>From Date</th>
          <th>To Date</th>
          <th>Vehicle</th>
          <th>Requested By</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($requisitions as $key => $r): ?>
        <tr>
          <td><?= ++$key ?></td>
          <td><?= $r->from_date ?></td>
          <td><?= $r->to_date ?></td>
          <td><?= $r->vehicle_id ?></td>
          <td><?= $r->req_person ?></td>
          <td><?= $r->status ?></td>
          <td>
            <?php if($r->status == 'Pending'): ?>
              <a href="<?= site_url('admin/vehicle_requisition/approve/'.$r->id) ?>" class="btn btn-success btn-sm">Approve</a>
              <a href="<?= site_url('admin/vehicle_requisition/reject/'.$r->id) ?>" class="btn btn-danger btn-sm">Reject</a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

