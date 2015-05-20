package com.example.wemped.virtualtourskeleton;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.ListFragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by wemped on 5/7/15.
 */

/*Fragment that each floor tab will contain*/

public class TabFragment extends ListFragment{
    private String tabName = null;
    private int tabId = 0;
    private int mapId = 0;
    ArrayList<Stop> stops = null;

    @Override
    public void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        this.mapId = getArguments().getInt("TAB_MAP_ID");
        this.tabId = getArguments().getInt("TAB_ID");
        this.tabName = getArguments().getString("TAB_ITEM_NAME");
        this.stops = Globals.getStopsWithMapId(this.mapId);
    }

    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
        StopListAdapter adapter = new StopListAdapter(getActivity(),this.stops);
        setListAdapter(adapter);
    }

    @Override
    public void onListItemClick(ListView l,View v, int position, long id){
        //Create intent to stopActivity
        //go to intent
        Intent stopIntent = new Intent(getActivity(),StopActivity.class);

        stopIntent.putExtra("STOP_ID",v.getId());

        startActivity(stopIntent);
    }

    public int getMapId(){
        return this.mapId;
    }
    public String getTabName(){return this.tabName;}

    /*This adapter and its corresponding xml layouts will be where we can edit
     and design our Stop buttons and their arrangement*/
    public class StopListAdapter extends ArrayAdapter<Stop>{
        public StopListAdapter(Context context, ArrayList<Stop> stops){
            super(context,0,stops);
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent){
            Stop stop = getItem(position);
            if(convertView==null){
                convertView=LayoutInflater.from(getContext()).inflate(R.layout.stop_list_item,parent,false);
            }
            TextView name = (TextView) convertView.findViewById(R.id.textView);
            name.setText(stop.getStopName());

            convertView.setId(stop.getStopID());

            return convertView;
        }
    }

}
