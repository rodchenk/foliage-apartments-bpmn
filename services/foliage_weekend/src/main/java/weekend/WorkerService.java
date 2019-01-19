package weekend;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.ObjectOutputStream;
import java.net.URL;
import java.time.LocalDate;
import java.time.Year;
import java.util.ArrayList;
import java.util.Base64;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;
import java.util.logging.Logger;
import java.util.stream.Collectors;

import org.camunda.bpm.client.task.ExternalTask;
import org.camunda.bpm.client.task.ExternalTaskHandler;
import org.camunda.bpm.client.task.ExternalTaskService;
import org.camunda.bpm.engine.variable.Variables;
import org.camunda.bpm.engine.variable.value.ObjectValue;

import com.google.gson.Gson;

public class WorkerService implements ExternalTaskHandler{

	private static final Logger sLogger = Logger.getLogger(WorkerService.class.getName());
	
	@SuppressWarnings("serial")
	public void execute(ExternalTask externalTask, ExternalTaskService externalTaskService) {
		sLogger.info("2. External service weekendAPI has been started");
		
		Map<String, Object> m = externalTask.getAllVariables();
					
		LocalDate start = LocalDate.parse((CharSequence) m.get("from"));
		LocalDate end = LocalDate.parse((CharSequence) m.get("to"));
		List<LocalDate> totalDates = new ArrayList<LocalDate>();
		while (!start.isAfter(end)) {
		    totalDates.add(start);
		    start = start.plusDays(1);
		}
		
		Map<String, Map<String, Boolean>> result = new TreeMap<>(); /* e.g. 2019-01-01 : {"weekend" : false, "holiday" : true} */
		/*fill map with key: date (like 2019-01-13) and value (HashMap with key: holiday/weekend and value true/false)*/
		for(int i = 0; i < totalDates.size(); i++) {
			String date = totalDates.get(i).toString();
			result.put(date, new HashMap<String, Boolean>() {{
		        put("Holiday", isHoliday(date));
		        put("Weekend", isWeekend(date));
		    }});
		}
		
		result.forEach((key, value)->{
			System.out.println("key: " + key + "; holiday: " + value.get("Holiday") + "; weekend: " + value.get("Weekend"));
		});
				
		Map<String, Object> data = new TreeMap<>();
		
		data.put("Day", result);
		
		externalTaskService.complete(externalTask, data);
	}
	
	/**
	 * @category RestAPI
	 * @see {@link https://feiertage-api.de}
	 * @param str {@link String} like <b>2019-04-19</b>
	 * @return {@link Boolean} if day is holiday, false otherwise
	 */
	private boolean isHoliday(String str) {
		String api_url = "https://feiertage-api.de/api/?jahr=" + Year.now().getValue() + "&nur_daten=1";
		URL url;
		
		try {
			url = new URL(api_url);
			InputStreamReader reader = new InputStreamReader(url.openStream());
			@SuppressWarnings("unchecked")
			Map<String, String> map = new Gson().fromJson(reader, HashMap.class);
			Map<String, String> swapped = map.entrySet().stream().collect(Collectors.toMap(Map.Entry::getValue, Map.Entry::getKey));
			
			String day = swapped.get(str);
			//sLogger.info(day == null ? str + " is not a holiday" : str + " is " + swapped.get(str));
			return day != null;
			
		} catch (IOException e) {
			e.printStackTrace();
		}
		
		return false;
	}
	
	/**
	 * @author Mischa
	 * @param str {@link String} like <b>2019-04-19</b>
	 * @return {@link Boolean} true if date is weekend, otherwise false
	 */
	private boolean isWeekend(String str) {
		Calendar c = Calendar.getInstance();
	    c.setTime(parseToDate(str));
		return c.get(Calendar.DAY_OF_WEEK) == Calendar.SATURDAY || c.get(Calendar.DAY_OF_WEEK) == Calendar.SUNDAY;
	}
	
	/**
	 * @author Mischa
	 * @param str {@link String} like <b>2019-04-19</b>
	 * @return correct {@link Date} or <code>null</code>
	 * @see is used also in {@link {availability.FoliageServiceWorker}}
	 */
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
