package availability;

import java.util.Date;

public class Apartment {
	
	private Date from;
	private Date to;
	private int id;
	
	public int getID() {
		return id;
	}
	
	public void setID(int id) {
		this.id = id;
	}
	
	public Date getFrom() {
		return from;
	}
	
	public void setFrom(Date from) {
		this.from = from;
	}
	
	public Date getTo() {
		return to;
	}
	
	public void setTo(Date to) {
		this.to = to;
	}

	public Boolean isFree() {
		//dummy process
		return Math.random() > 0.5;
	}
}