package com.example.wemped.virtualtourskeleton;

/**
 * Created by wemped on 4/23/15.
 */
public class Globals {
    static private Stop[] Stops;

    static public void setStops(Stop[] stops) {Stops = stops;}
    static public Stop[] getStops() {return Stops;}

    static private Map[] Maps;

    static public void setMaps(Map[] maps) {Maps = maps;}
    static public Map[] getMaps() {return Maps;}
}
