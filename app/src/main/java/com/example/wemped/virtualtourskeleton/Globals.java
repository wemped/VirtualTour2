package com.example.wemped.virtualtourskeleton;

import android.renderscript.Element;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Created by wemped on 4/23/15.
 */
public class Globals {
    /*Stops*/
    static private Stop[] Stops;

    static public void setStops(Stop[] stops) {Stops = stops;}
    static public Stop[] getStops() {return Stops;}
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

    /*Maps*/
    static private Map[] Maps;

    static public void setMaps(Map[] maps) {Maps = maps;}
    static public Map[] getMaps() {return Maps;}
}
