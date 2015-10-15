package com.example.wemped.virtualtourskeleton;

import android.content.Context;
import android.graphics.Typeface;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Created by wemped on 4/23/15.
 */
public class Globals {
    /*Stops*/
    static private Stop[] Stops = null;
    static private Stop[] AllStops = null;

    static public void setStops(Stop[] stops) {
        Arrays.sort(stops);
        Stops = stops;
    }
    static public void setAllStops(Stop[] stops){
        Arrays.sort(stops);
        AllStops = stops;
    }
    static public Stop[] getStops() {return Stops;}
    static public Stop[] getAllStops() {return AllStops;}
    static public List<Stop> getStopsList(){return (Arrays.asList(Stops));}
    static public ArrayList<Stop> getStopsWithMapId(int mapId){
        int length = Stops.length;
        ArrayList<Stop> stopsWithId = new ArrayList<Stop>();
        for (int s=0;s<length;s++){
            if (Stops[s].getStopMapID() == mapId){
                stopsWithId.add(Stops[s]);
            }
        }
        return stopsWithId;
    }
    static public Stop getStopById(int id){
        if(Stops==null){
            int length = Stops.length;
            for (int i=0;i<length;i++){
                if (Stops[i].getStopID() == id){
                    return Stops[i];
                }
            }
        }
        return null;
    }

    /*Maps*/
    static private Map[] Maps;

    static public void setMaps(Map[] maps) {
        Arrays.sort(maps);
        Maps = maps;
    }
    static public Map[] getMaps() {return Maps;}

    /*Misc*/
    static public boolean isOnline(Context context) {


        final ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);

        final NetworkInfo networkInfo = cm.getActiveNetworkInfo();

        if(networkInfo != null) {
            int type = networkInfo.getType();
        }else{
            return false;
        }
        String typeName = networkInfo.getTypeName();

        boolean connected = networkInfo.isConnected();

        if (connected)
            return true;
        else
            return false;
    }
    static public Typeface getAvenir(Context c){
        return Typeface.createFromAsset(c.getAssets(), "fonts/avenir-light.ttf");
    }
}
