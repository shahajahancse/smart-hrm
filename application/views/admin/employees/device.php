  <?php
//   dd($result[0]->device);
    $devicearray=json_decode($result[0]->device);
    
    ?>
    <div class="col-md-12" style="justify-content: center;display: flex;">
      <div class="col-md-6" style="border-radius: 7px;background: #ffffff;box-shadow: inset 1px 0px 3px #cbcbcb, inset -2px -1px 5px #cdc3c3;padding: 14px;">
                                     <div class="col-md-6" style="text-align: center;">
                                   
                                            <table class="table">
                                              <tbody>
                                                <tr><th><input type="checkbox" onclick="return false;" name="laptop" id="" <?= in_array(1,$devicearray)?'checked':'' ?>></th><td>Laptop</td></tr>
                                                <tr><th><input type="checkbox" onclick="return false;" name="laptop_cherger" id="" <?= in_array(2,$devicearray)?'checked':'' ?>></th><td>Laptop Cherger</td></tr>
                                                <tr><th><input type="checkbox" onclick="return false;" name="mouse" id="" <?= in_array(3,$devicearray)?'checked':'' ?>></th><td>Mouse</td></tr>
                                                <tr><th><input type="checkbox" onclick="return false;" name="converter" id="" <?= in_array(4,$devicearray)?'checked':'' ?>></th><td>Converter</td></tr>
                                                <tr><th><input type="checkbox" onclick="return false;" name="Headphone" id="" <?= in_array(5,$devicearray)?'checked':'' ?>></th><td> Headphone</td></tr>
                                                <tr><th><input type="checkbox" onclick="return false;" name="extra_monitor" id="" <?= in_array(6,$devicearray)?'checked':'' ?>></th><td>Extra-monitor</td></tr>
                                   
                                              </tbody>

                                            </table>
                                        
                                        </div>
                                          <div class="col-md-6" style="text-align: center;">
                                                <table class="table">
                                                     <tbody>
                                                         <tr><th><input type="checkbox" onclick="return false;" name="cpu" id="" <?= in_array(7,$devicearray)?'checked':'' ?>></th><td>CPU</td></tr>
                                                         <tr><th><input type="checkbox" onclick="return false;" name="ups" id="" <?= in_array(8,$devicearray)?'checked':'' ?>></th><td>UPS</td></tr>
                                                         <tr><th><input type="checkbox" onclick="return false;" name="power_cable" id="" <?= in_array(9,$devicearray)?'checked':'' ?>></th><td>Power Cable</td></tr>
                                                         <tr><th><input type="checkbox" onclick="return false;" name="vga_cable" id="" <?= in_array(10,$devicearray)?'checked':'' ?>></th><td>VGA Cable</td></tr>
                                                         <tr><th><input type="checkbox" onclick="return false;" name="smart_phone" id="" <?= in_array(11,$devicearray)?'checked':'' ?>></th><td>Smart Phone</td></tr>
                                                         <tr><th><input type="checkbox" onclick="return false;" name="bpws" id="" <?= in_array(12,$devicearray)?'checked':'' ?>></th><td>Botton Phone With Sim</td></tr>
                                                       
                                                      </tbody>

                                              </table>
                                              
                                     
                                      </div>
                            </div>
                        </div>
 </div>