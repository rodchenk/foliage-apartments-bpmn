package availability;

import java.util.Date;
import java.util.GregorianCalendar;
import java.util.HashMap;
import java.util.Map;
import java.util.logging.Logger;

import org.camunda.bpm.client.task.ExternalTask;
import org.camunda.bpm.client.task.ExternalTaskHandler;
import org.camunda.bpm.client.task.ExternalTaskService;

public class FoliageServiceWorker implements ExternalTaskHandler{
	private static final Logger sLogger = Logger.getLogger(FoliageServiceWorker.class.getName());
	
	@Override
	public void execute(ExternalTask externalTask, ExternalTaskService externalTaskService) {
		sLogger.info("2. External service has been started");
		Map <String, Object> data = new HashMap<String, Object>();
		
		/*can be used later by accesing to Database*/

		Apartment apartment = new Apartment();
//    	Date lFromDate = parseToDate(externalTask.getVariable("from"));//Thu Jan 24 00:00:00 CET 2019
//    	Date lToDate = parseToDate(externalTask.getVariable("to"));
//    	int lID = externalTask.getVariable("id");
    	
//    	apartment.setID(lID);
//    	apartment.setFrom(lFromDate);
//    	apartment.setTo(lToDate);
    	
    	data.put("available", apartment.isFree());
    	data.put("from", externalTask.getVariable("from"));
    	data.put("to", externalTask.getVariable("to"));
    	
    	externalTaskService.complete(externalTask, data);		
	}
	
	/**
	 * @author Mischa
	 * @param str is Strin like 2019-01-24
	 * @return parsed Date or null if date was incorrect
	 */
	@SuppressWarnings("unused")
	private static Date parseToDate(Object str) {
		String [] dateArray = ((String) str).split("-");
		
		if(dateArray.length != 3)
			return null;
		
		int year = 	Integer.valueOf(dateArray[0]);
		int month = Integer.valueOf(dateArray[1])-1;//months beginn with 0
		int day = 	Integer.valueOf(dateArray[2]);
		
		return new GregorianCalendar(year, month, day).getTime();
	}
}
