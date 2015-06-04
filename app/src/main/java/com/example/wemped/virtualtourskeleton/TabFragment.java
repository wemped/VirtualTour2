package com.example.wemped.virtualtourskeleton;

import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.ListFragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.GridView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

import mehdi.sakout.fancybuttons.FancyButton;

/**
 * Created by wemped on 5/7/15.
 */

/*Fragment that each floor tab will contain*/

public class TabFragment extends Fragment{
    private String tabName = null;
    private int tabId = 0;
    private int mapId = 0;
    ArrayList<Stop> stops = null;
    GridView gridView;


    @Override
    public void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        this.mapId = getArguments().getInt("TAB_MAP_ID");
        this.tabId = getArguments().getInt("TAB_ID");
        this.tabName = getArguments().getString("TAB_ITEM_NAME");
        this.stops = Globals.getStopsWithMapId(this.mapId);
    }

    @Override
    public View onCreateView(LayoutInflater infalter, ViewGroup container, Bundle savedInstanceState){
        RelativeLayout mainTabLayout = new RelativeLayout(getActivity());
        this.gridView = new GridView(getActivity());

        mainTabLayout.addView(this.gridView);

        //THIS IS NEEDED IF THE ITEMS IN THE GRID ARE NOT CLICKABLE IN NATURE (ex. textviews are not clickable but buttons are)
        /*this.gridView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                //Create intent to stopActivity
                //go to intent
                Intent stopIntent = new Intent(getActivity(),StopActivity.class);
                stopIntent.putExtra("STOP_ID",view.getTag().toString());
                Log.v("onClick",view.getTag().toString());
                startActivity(stopIntent);
            }
        });*/
        this.gridView.setNumColumns(2);
        this.gridView.setStretchMode(GridView.STRETCH_COLUMN_WIDTH);
        return mainTabLayout;
    }


    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
        StopListAdapter adapter = new StopListAdapter(getActivity(),this.stops);
        //setListAdapter(adapter);
        this.gridView.setAdapter(adapter);
        gridView.setHorizontalSpacing(50);
    }


    public int getMapId(){
        return this.mapId;
    }
    public String getTabName(){return this.tabName;}

    /*This adapter and its corresponding xml layouts will be where we can edit
     and design our Stop buttons and their arrangement*/
    public class StopListAdapter extends ArrayAdapter<Stop>{

        /*public StopListAdapter(Context context, ArrayList<Stop> stops){
            super(context,0,stops);
        }

        @Override
        public View getView(int position,View convertView,ViewGroup parent){

        }*/
        public StopListAdapter(Context context, ArrayList<Stop> stops){
            super(context,0,stops);
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent){
            Stop stop = getItem(position);
            if(convertView==null){
                convertView=LayoutInflater.from(getContext()).inflate(R.layout.stop_list_item,parent,false);
            }

            FancyButton stopButton = (FancyButton)convertView.findViewById(R.id.stop_button);
            stopButton.setText(stop.getStopName());
            stopButton.setBackgroundColor(Color.parseColor("#003f87"));
            stopButton.setTextSize(17);
            stopButton.setRadius(5);
            stopButton.setTag(stop.getStopID());
            stopButton.setOnClickListener(new View.OnClickListener() {

                @Override
                public void onClick(View view) {
                    Intent stopIntent = new Intent(getActivity(),StopActivity.class);
                    stopIntent.putExtra("STOP_ID",Integer.valueOf(view.getTag().toString()));
                    Log.v("NEWonClick",view.getTag().toString());
                    startActivity(stopIntent);
                }
            });

            return convertView;
        }
    }

}
