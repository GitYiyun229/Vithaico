<table cellpadding="5" cellspacing="0"  border="1" bordercolor="#D1D1D1" width="100%" >
											<thead>
												<tr align="center" bgcolor="white">
													<th width="30"><b>STT</b></th>
													<th width="30%"><b><?php echo "Thông tin đơn hàng";?></b></th>
<!--													<th width="130" ><b><?php echo "Hình thức mua hàng"; ?></b></th>-->
													<th width="10%"><b><?php echo "Trạng thái"; ?></b></th>
													<th width="10%"><b><?php echo "Ngày đặt hàng"; ?></b></th>
													<th width="10%"><b><?php echo "Người giới thiệu"; ?></b></th>
													<th width="10%"><b><?php echo "Hoa hồng"; ?></b></th>
													<th width="10%"><b><?php echo "Thanh toán cho CTV"; ?></b></th>
													<th width="5%"><?php echo '&nbsp'; ?></th>
											  	</tr>
											  </thead>
											<tbody>
											<?php $total_commission = 0;?>
											<?php for($i = 0 ; $i < count($orders_children_intro); $i ++ ){?>
											<?php
												 $item = $orders_children_intro[$i];
												 $link_view =FSRoute::_('index.php?module=products&view=order_intro&id='.$item->id.'&my=0&task=detail&Itemid=45');
												 $member = isset($children_members[$item -> collaborator_id])?$children_members[$item -> collaborator_id]:null;
											?>
												<tr class='row<?php echo ($i%2); ?>'>
													<td align="center">
														<strong><?php echo ($i+1); ?></strong><br/>
													</td>
													
													<td> 
														<?php 
													 	$estore_code = 'DH';
													 	$estore_code .= str_pad($item -> id, 8 , "0", STR_PAD_LEFT);
														?>
														<p>Mã đơn hàng: <span class='orange'><?php echo $estore_code ?></span><br/></p>
														<p>	Tổng tiền <strong class='total_price'><?php  echo format_money($item -> total_after_discount).' '; ?></strong></p>
													</td>
													
													<!--<td>
														<?php if($item ->payment_method ==0){
																echo "Mua trực tiếp";
														}else echo "Mua thông qua address";?>
													</td>
													--><td><?php 
														$status = $this -> showStatus($item -> status);
														echo $item -> status == 1?'<strong class="blue">'.$status.'</strong>':'<strong class="red">'.$status.'</strong>';
													?></td>
													<td>
														<?php echo date('d/m/Y',strtotime($item->created_time));?>
													</td>
													<td>
														<?php echo isset($member ->full_name)?$member ->full_name:'-';?>
													</td>
													<td>
														<?php $commission = ($item ->  total_after_discount * $commission_rate_children /100);?>
														<?php $total_commission += $commission;?>
														<?php echo format_money($commission);?>
													</td>
													<td>
														<?php echo $item -> payment_for_collaborator?'<strong class="blue">Đã thanh toán</strong>':'<strong class="red">Chưa thanh toán</strong>';?>
													</td>
													<td><a class="thickbox" rel="<?php echo $estore_code;?>" href="<?php echo $link_view.'&raw=1'; ?>" rev="<?php echo $link_view; ?>"> Xem chi tiết </a></td>
												</tr>
											<?php } ?>
											<tr class='row<?php echo ($i%2); ?>'>
													<td align="center" colspan="4">
													</td>
													<td>
														<strong><?php echo format_money($total_commission);?></strong>
													</td>
													<td colspan="2">
													</td>
												</tr>
											</tbody>
										</table>