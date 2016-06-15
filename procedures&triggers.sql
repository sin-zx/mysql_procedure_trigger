-- 1.创建展示每个表的存储过程
delimiter //
create procedure show_employees()
	begin
		select * from employees;
	end 
//

create procedure show_logs()
	begin
		select * from logs;
	end 
//

create procedure show_products()
	begin
		select * from products;
	end 
//

create procedure show_purchases()
	begin
		select * from purchases;
	end 
//

create procedure show_suppliers()
	begin
		select * from suppliers;
	end 
//

create procedure find_product(IN prod_id int)
	begin
		select * from products where pid = prod_id;
	end 
//
delimiter ;

--2.report_monthly_sale(prod_id)
delimiter //
create procedure report_monthly_sale(IN prod_id int)
	begin
		select pname,imgname,left( date_format(ptime,'%M'),3) as month,year(ptime) as year,sum(qty) as total_qty,sum(total_price) as total_dollar,sum(total_price)/sum(qty) as avg_price from purchases,products where purchases.pid = prod_id and purchases.pid = products.pid group by DATE_FORMAT(ptime,'%Y-%m');
	end 
//
delimiter ;

--function test
create function func(name varchar(50)) returns int
begin
	declare sal1 int;
	select sal into sal1 from emp2013800476 where ENAME = name;
	return (sal1); 
end //

--3.
create procedure add_purchase(IN c_id int, e_id int, p_id int, pur_qty int)
	begin
		declare totalprice decimal(7,2);
		declare ori_price decimal(6,2);
		declare rate decimal(3,2);
		declare old_qoh int;
		declare old_plus_sold int;
		select original_price,discnt_rate,qoh into ori_price,rate,old_qoh from products where pid = p_id;

		set totalprice = ori_price*(1-rate)*pur_qty;

		if old_qoh - pur_qty < (select qoh_threshold from products where pid = p_id) then
		   set old_plus_sold = old_qoh + pur_qty;
		   select old_qoh,old_plus_sold;
		   update products set qoh = 2*old_qoh where pid = p_id;
		end if;

		insert into purchases(cid,eid,pid,qty,ptime,total_price) 
			values(c_id, e_id, p_id, pur_qty,CURRENT_TIMESTAMP,totalprice);
	end //	

create procedure new_product(IN pname_ varchar(15), qoh_ int(5), qoh_threshold_ int(5), 
	original_price_ decimal(6,2),discnt_rate_ decimal(3,2),sid_ int,imgname_ varchar(50) )
	begin
		insert into products(pname, qoh, qoh_threshold, original_price,discnt_rate,sid,imgname) 
			values(pname_, qoh_, qoh_threshold_, original_price_,discnt_rate_,sid_,imgname_);
	end //	

create procedure del_product(IN p_id int)
	begin
		delete from products where pid = p_id;
	end //	

create procedure get_product_qoh(IN p_id int)
	begin
		select qoh from products where pid = p_id;
	end //

--创建相应的触发器对相关表进行修改

	--减去相关商品数目，并修改customer的访问次数和时间
drop trigger if exists after_purchase //
create trigger after_purchase after insert on purchases for each row
	begin
		update products set qoh = qoh - new.qty where pid = new.pid;
		update customers set visits_made = visits_made + 1,last_visit_time = new.ptime where cid = new.cid;
	end //


--5 创建函数返回商品的库存，用于交易时确认库存是否足够
create function get_product_qty(p_id int) returns int
begin
	declare qty int;
	select qoh into qty from products where pid = p_id;
	return (qty); 
end //

--4.log相关触发器
drop trigger if exists log_insert_purchase //
create trigger log_insert_purchase after insert on purchases for each row
	begin
		insert into logs(who,time,table_name,operation,key_value) 
			values('root',CURRENT_TIMESTAMP,'purchases','insert',new.purid);
	end //

drop trigger if exists log_update_qoh //
create trigger log_update_qoh after update on products for each row
	begin
	if new.qoh != old.qoh then
		insert into logs(who,time,table_name,operation,key_value) 
			values('root',CURRENT_TIMESTAMP,'products','update',new.pid);
	end if;
	end //

drop trigger if exists log_update_visit //
create trigger log_update_visit after update on customers for each row
	begin
	if new.visits_made != old.visits_made then
		insert into logs(who,time,table_name,operation,key_value) 
			values('root',CURRENT_TIMESTAMP,'customers','update',new.cid);
	end if;
	end //
