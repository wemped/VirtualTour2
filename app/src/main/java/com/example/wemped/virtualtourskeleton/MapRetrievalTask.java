package com.example.wemped.virtualtourskeleton;

import android.os.AsyncTask;
import android.util.Log;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.Arrays;

/**
 * Created by wemped on 4/23/15.
 */
public class MapRetrievalTask extends AsyncTask<Void,Void,Map[]> {

    private static final String MAP_URL = "http://sw.cs.wwu.edu/~vut3/virtualtour/maps/list.php";
    //private static final String MAP_URL = "http://sw.cs.wwu.edu/~ragsdan/csvirtualtour/maps/list.php";
    //private static final String MAP_URL = "http://140.160.162.254/csvirtualtour/maps/list";

    private OnTaskCompleted listener;
    public MapRetrievalTask(MainActivity listener){
        this.listener = listener;
    }

    @Override
    protected Map[] doInBackground(Void... params){
        try{
            return GetMaps();
        }catch (MalformedURLException e){
            e.printStackTrace();
        }
        return null;
    }

    private Map[] GetMaps() throws MalformedURLException{
        Map[] returned = null;
        StringBuilder builder = new StringBuilder();
        URL httpGet;
        httpGet = new URL(MAP_URL);
        try {
            //Log.v("StopGenerator","attempting..");
            InputStream in = httpGet.openStream();
            //Log.v("StopGenerator","Got herrre");
            InputStreamReader content = new InputStreamReader(in);
            BufferedReader reader = new BufferedReader(content);
            String line;
            //Log.v("maps","here!");
            while ((line = reader.readLine()) != null) {
                builder.append(line);
                //Log.v("maps","readline not null...");
            }
        } catch (Exception e) {
            Log.d("StopGenerator", "" + e.getMessage());
        }

        String data = builder.toString();
        //Log.v("maps","converted to a string");
        JSONObject jsonObject;
        try {
            jsonObject = new JSONObject(data);
            JSONArray maps = jsonObject.getJSONArray("result");
            returned = new Map[maps.length()];
            //Log.v("maps","created Map array");
            for (int i = 0; i < maps.length(); i++)
            {
                JSONObject map = maps.getJSONObject(i);
                returned[i] = new Map(map.getInt("id"), map.getString("url"),map.getString("desc"), map.getInt("ordering"));
                //Log.v("maps","filled in a Map");
            }

        } catch (JSONException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
        //Log.v("maps",returned[0].getMapDescription());
        return returned;
    }

    protected void onPostExecute(Map[] Result){
        if (Result == null){
            Log.v("mapretrieval","result is null");
        }else {
            Globals.setMaps(Result);
            listener.onTaskCompleted(Result);
        }
    }

}
