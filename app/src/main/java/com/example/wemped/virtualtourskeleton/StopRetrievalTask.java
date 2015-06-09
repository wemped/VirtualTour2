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
public class StopRetrievalTask extends AsyncTask<Integer,Void,Stop[]>{


    //private static final String STOP_URL = "http://sw.cs.wwu.edu/~vut3/virtualtour/jsonapi?stopid=";

    private static final String STOP_URL = "http://sw.cs.wwu.edu/~ragsdan/csvirtualtour/jsonapi?stopid=";

    private OnTaskCompleted listener;
    public StopRetrievalTask(OnTaskCompleted listener){
        this.listener = listener;
    }

    protected Stop[] doInBackground(Integer... params){
        Stop[] stops = null;
        try{
            //Call stops = StopGenerator.RequestStop
            stops = GetStops((int)params[0]);
        }catch (MalformedURLException e){
            e.printStackTrace();
        }
        return stops;
    }

    protected void onPostExecute(Stop[] Result){
        if (Result != null) {
            Globals.setStops(Result);
            listener.onTaskCompleted(Result);
        }
    }

    private Stop[] GetStops(int stopId) throws MalformedURLException{
        StringBuilder builder = new StringBuilder();
        URL httpGet = new URL(STOP_URL + stopId);


        //Log.d("StopGenerator", "Got here");
        try {
            InputStream in = httpGet.openStream();
            //Log.d("StopGenerator","Got herrre");
            InputStreamReader content = new InputStreamReader(in);
            BufferedReader reader = new BufferedReader(content);
            String line;
            while ((line = reader.readLine()) != null) {
                builder.append(line);
            }
        } catch (Exception e) {
            Log.d("StopGenerator", "" + e.getMessage());
        }
        //stopId -1 is a special case for the main Screen
        if (stopId == -1) {
            return ParseMainScreen(builder.toString());
        }
        //All other stops just have a single stop entity
        else {
            return ParseSingleStop(builder.toString());
        }

    }

    private static Stop[] ParseMainScreen(String data){
        Stop[] returned;
        try {
            JSONObject jsonObject = new JSONObject(data);
            JSONArray stops = jsonObject.getJSONObject("result").getJSONArray("StopList");
            //Log.d("StopGenerator", stops.toString());/login.php

            returned = new Stop[stops.length()];

            for (int i = 0; i < stops.length() ; i++){
                JSONObject stop = stops.getJSONObject(i);
                returned[i] = new Stop(stop.getString("StopName"), stop.getInt("StopID"), stop.getInt("StopOrder"),(float)stop.getDouble("StopX"),(float)stop.getDouble("StopY"),stop.getString("StopQRIdentifier"),"null",stop.getInt("MapID"),stop.getString("RoomNumber"));
            }
            return returned;

        } catch (JSONException e) {
            // TODO Auto-generated catch block
            Log.d("StopGenerator",e.getMessage());
        }
        return null;
    }

    private static Stop[] ParseSingleStop(String data){
        Stop[] returned = new Stop[1];
        try {
            JSONObject jsonObject = new JSONObject(data);
            JSONObject stop = jsonObject.getJSONObject("result");
            //Log.d("StopGenerator", stop.toString());

            returned[0] = new Stop(stop.getString("StopName"), stop.getInt("StopID"), stop.getInt("StopOrder"), (float)stop.getDouble("StopX"),
                    (float)stop.getDouble("StopY"), stop.getString("StopQRIdentifier"), stop.getString("StopContent"), stop.getInt("MapID"),stop.getString("RoomNumber"));
        } catch (JSONException e) {
            Log.d("StopGenerator","" + e.getMessage());
        }
        return returned;
    }
}
